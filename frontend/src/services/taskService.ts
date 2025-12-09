import api from '../api/api';
import type { Task } from '../types';

// Get all tasks
export const getTasks = () => api.get<{ data: Task[] }>('/tasks');

// Get single task
export const getTask = (id: number) => api.get<{ data: Task }>(`/tasks/${id}`);

// Create task
export const createTask = (data: Partial<Task>) => api.post<{ data: Task }>('/tasks', data);

// // Update task (use POST as backend requires)
// export const updateTask = (id: number, data: Partial<Task>) =>
//   api.post<{ data: Task }>(`/tasks/${id}`, data);

export const updateTask = (id: number, data: Partial<Task>) =>
  api.put<{ data: Task }>(`/tasks/${id}`, data);
// Changed from api.post to api.put

// Delete task
export const deleteTask = (id: number) => api.delete(`/tasks/${id}`);


