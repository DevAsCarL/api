import axios from "axios";

const API_BASE_URL = "http://127.0.0.1:8000/api";
//const API_BASE_URL = 'https:///api';

export async function registerUser(userData) {
  return axios.post(`${API_BASE_URL}/register`, userData)
    .then(({ data }) => data)
    .catch(error => {
      throw error;
    });
}

export async function loginUser(userData) {
  return axios.post(`${API_BASE_URL}/login`, userData)
    .then(({ data }) => data)
    .catch(error => {
      throw error;
    });
}

export async function getTodos(token, userId) {
  return axios.get(`${API_BASE_URL}/todos`, {
    headers: {
      "Authorization": `Bearer ${token}`,
    },
    params: {
      userId: userId,
    },
  })
    .then(({ data }) => data)
    .catch(error => {
      throw error;
    });
}

export async function createTodo(todo, token, userId) {
  return axios.post(`${API_BASE_URL}/todos`, todo, {
    headers: {
      "Authorization": `Bearer ${token}`,
    },
    params: {
      userId: userId,
    },
  })
    .then(({ data }) => data)
    .catch(error => {
      throw error;
    });
}

export async function updateTodo(todo, token) {
  if (todo.completed) {
    todo.completed_time = Date.now();
  } else {
    todo.completed_time = null;
  }

  return axios.put(`${API_BASE_URL}/todos/${todo.id}`, todo, {
    headers: {
      "Authorization": `Bearer ${token}`,
    },
  })
    .then(({ data }) => data)
    .catch(error => {
      throw error;
    });
}

export async function deleteTodo(id, token) {
  return axios.delete(`${API_BASE_URL}/todos/${id}`, {
    headers: {
      "Authorization": `Bearer ${token}`,
    },
  })
    .then(({ data }) => data)
    .catch(error => {
      throw error;
    });
}

export async function deleteAllTodos(token, userId) {
  return axios.delete(`${API_BASE_URL}/todos/delete/all`, {
    headers: {
      "Authorization": `Bearer ${token}`,
    },
    params: {
      userId: userId,
    },
  })
    .then(({ data }) => data)
    .catch(error => {
      throw error;
    });
}
