<template>
  <div class="page">

    <div class="layout">

      <!-- LEFT: CREATE / EDIT TASK -->
      <div class="left">
        <div class="card">
          <h2 class="card-title">{{ editing ? 'Edit Task' : 'Create Task' }}</h2>

          <form @submit.prevent="submitTask" class="form">
            <label class="label">Title</label>
            <input v-model="taskForm.title" class="input" placeholder="Task title" required />

            <label class="label">Description</label>
            <textarea v-model="taskForm.description" class="textarea" placeholder="Task details..."></textarea>

            <label class="label">Status</label>
            <select v-model="taskForm.status" class="input">
              <option value="pending">Pending</option>
              <option value="in_progress">In Progress</option>
              <option value="completed">Completed</option>
            </select>

            <label class="label">Priority</label>
            <select v-model="taskForm.priority" class="input">
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>

            <label class="label">Due Date</label>
            <input v-model="taskForm.due_date" type="date" class="input" />

            <button class="btn" type="submit">{{ editing ? 'Update Task' : 'Create Task' }}</button>
          </form>
        </div>
      </div>

      <!-- RIGHT: TASKS LIST -->
      <div class="right">
        <h2 class="section-title">All Tasks</h2>

        <div class="task-list">
          <div v-for="task in tasks" :key="task.id" class="task-card">
            <div class="task-header">
              <h3 class="task-title">{{ task.title }}</h3>
              <span :class="['badge', task.status]">{{ task.status }}</span>
            </div>

            <p class="desc">{{ task.description }}</p>
            <p class="meta">Priority: <span :class="['priority', task.priority]">{{ task.priority }}</span></p>
            <p class="meta">Due: {{ task.due_date }}</p>

            <div class="actions">
              <button class="btn small success" @click="changeStatus(task, 'completed')">Complete</button>
              <button class="btn small warning" @click="editTask(task)">Edit</button>
              <button class="btn small danger" @click="confirmDelete(task.id)">Delete</button>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- TOASTER -->
    <div v-if="toast.show" class="toast" :class="toast.type">{{ toast.message }}</div>
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
import type { Task } from "../types";
import { getTasks, createTask as createTaskApi, deleteTask as deleteTaskApi, updateTask } from "../services/taskService";

const tasks = ref<Task[]>([]);

// Form data
const taskForm = ref({
  title: "",
  description: "",
  status: "pending",
  priority: "medium",
  due_date: "",
});

// Editing state
const editing = ref(false);
const editingId = ref<number | null>(null);

// Toast
const toast = ref({ show: false, message: "", type: "" });

const showToast = (message: string, type: string = "success") => {
  toast.value = { show: true, message, type };
  setTimeout(() => (toast.value.show = false), 2000);
};

// Fetch tasks
const fetchTasks = async () => {
  const res = await getTasks();
  tasks.value = res.data.data;
};

// Create / Update Task
const submitTask = async () => {
  if (editing.value && editingId.value !== null) {
    await updateTask(editingId.value, taskForm.value);
    showToast("Task updated!");
  } else {
    await createTaskApi(taskForm.value);
    showToast("Task created!");
  }

  resetForm();
  fetchTasks();
};

// Reset form
const resetForm = () => {
  taskForm.value = {
    title: "",
    description: "",
    status: "pending",
    priority: "medium",
    due_date: "",
  };
  editing.value = false;
  editingId.value = null;
};

// Edit task
const editTask = (task: Task) => {
  taskForm.value = { ...task };
  editing.value = true;
  editingId.value = task.id;
};

// Delete task
const confirmDelete = async (id: number) => {
  await deleteTaskApi(id);
  showToast("Task deleted!", "danger");
  fetchTasks();
};

// Change status
const changeStatus = async (task: Task, status: string) => {
  await updateTask(task.id, { status });
  showToast("Status updated!");
  fetchTasks();
};

onMounted(fetchTasks);
</script>

<style scoped>
.page {
  background: #f4f6f9;
  min-height: 100vh;
  padding: 30px;
}
.layout {
  display: grid;
  grid-template-columns: 3fr 9fr;
  gap: 25px;
}
.left, .right { width: 100%; }
.card {
  background: white;
  padding: 22px;
  border-radius: 14px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  border: 1px solid #e5e7eb;
}
.card-title { font-size: 20px; font-weight: 700; margin-bottom: 18px; }
.form { display: flex; flex-direction: column; gap: 12px; }
.label { font-size: 14px; font-weight: 600; color: #374151; }
.input, .textarea, select {
  width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1;
  border-radius: 8px; font-size: 14px; background: #f9fafb;
  outline: none; transition: 0.2s;
}
.textarea { min-height: 80px; resize: vertical; }
.input:focus, .textarea:focus, select:focus {
  background: white; border-color: #3b82f6; box-shadow: 0 0 0 2px #3b82f640;
}
.btn {
  background: #2563eb; color: white; border: none;
  padding: 12px; border-radius: 10px; cursor: pointer; font-weight: 600;
  transition: 0.15s;
}
.btn:hover { background: #1e40af; }
.small { padding: 7px 10px; font-size: 12px; }
.success { background: #22c55e; }
.success:hover { background: #16a34a; }
.warning { background: #facc15; }
.warning:hover { background: #eab308; }
.danger { background: #ef4444; }
.danger:hover { background: #dc2626; }
.section-title { font-size: 24px; font-weight: 700; margin-bottom: 16px; }
.task-list { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.task-card { background: white; padding: 18px; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 3px 12px rgba(0,0,0,0.06); }
.task-header { display: flex; justify-content: space-between; align-items: center; }
.task-title { font-weight: 700; font-size: 16px; }
.desc { margin: 10px 0; color: #4b5563; font-size: 14px; }
.meta { font-size: 13px; color: #6b7280; }
.badge { padding: 5px 10px; border-radius: 8px; font-size: 12px; font-weight: 600; text-transform: capitalize; }
.pending { background: #fef3c7; color: #92400e; }
.in_progress { background: #dbeafe; color: #1d4ed8; }
.completed { background: #dcfce7; color: #166534; }
.priority { font-weight: 600; text-transform: capitalize; }
.priority.low { color: #0ea5e9; }
.priority.medium { color: #f59e0b; }
.priority.high { color: #dc2626; }
.actions { display: flex; gap: 8px; margin-top: 10px; }

/* TOASTER */
.toast {
  position: fixed; top: 20px; right: 20px; padding: 14px 20px;
  border-radius: 8px; color: #fff; font-weight: 600;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15); z-index: 999;
  transition: 0.3s;
}
.toast.success { background: #22c55e; }
.toast.danger { background: #ef4444; }
.toast.warning { background: #facc15; color: #000; }
</style>
