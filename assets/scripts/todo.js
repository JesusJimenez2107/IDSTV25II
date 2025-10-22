let currentEditId = null;

function getTasks() {
  const raw = JSON.parse(localStorage.getItem("tasks")) || [];
  return raw.map(t =>
    typeof t === "string" ? { id: genId(), text: t, done: false } :
    { id: t.id || genId(), text: t.text, done: !!t.done }
  );
}

function setTasks(tasks) {
  localStorage.setItem("tasks", JSON.stringify(tasks));
}

function genId() {
  return String(Date.now()) + Math.random().toString(16).slice(2);
}

function addTaskToStorage(text) {
  const tasks = getTasks();
  const task = { id: genId(), text, done: false };
  tasks.push(task);
  setTasks(tasks);
  return task;
}

function deleteTaskFromStorage(id) {
  setTasks(getTasks().filter(t => t.id !== id));
}

function toggleDoneInStorage(id, done) {
  setTasks(getTasks().map(t => (t.id === id ? { ...t, done } : t)));
}

function updateTextInStorage(id, newText) {
  setTasks(getTasks().map(t => (t.id === id ? { ...t, text: newText } : t)));
}

function renderTask(task) {
  const li = document.createElement("li");
  li.className = "todo-item";
  li.dataset.id = task.id;

  const left = document.createElement("div");
  left.className = "left";

  const checkbox = document.createElement("input");
  checkbox.type = "checkbox";
  checkbox.checked = task.done;
  checkbox.onchange = () => toggleDoneInStorage(task.id, checkbox.checked);

  const span = document.createElement("span");
  span.className = "task-text";
  span.textContent = task.text;

  left.appendChild(checkbox);
  left.appendChild(span);

  const right = document.createElement("div");
  right.className = "right";

  const editBtn = document.createElement("button");
  editBtn.className = "btn-secondary";
  editBtn.textContent = "Editar";
  editBtn.onclick = () => openEditCard(task.id, task.text);

  const deleteBtn = document.createElement("button");
  deleteBtn.className = "btn-danger";
  deleteBtn.textContent = "Eliminar";
  deleteBtn.onclick = () => {
    li.remove();
    deleteTaskFromStorage(task.id);
  };

  right.append(editBtn, deleteBtn);
  li.append(left, right);
  return li;
}

function updateTodoList() {
  const list = document.getElementById("todo_list");
  list.innerHTML = "";
  getTasks().forEach(task => list.appendChild(renderTask(task)));
}

function getTask() {
  const input = document.getElementById("task_name");
  const text = input.value.trim();
  if (!text) return false;
  const task = addTaskToStorage(text);
  document.getElementById("todo_list").appendChild(renderTask(task));
  input.value = "";
  return false;
}

function openEditCard(id, text) {
  currentEditId = id;
  document.getElementById("edit_task_name").value = text;
  document.getElementById("edit_card").hidden = false;
}

function saveEdit() {
  const input = document.getElementById("edit_task_name");
  const newText = input.value.trim();
  if (!newText) return false;

  updateTextInStorage(currentEditId, newText);
  const li = document.querySelector(`li[data-id="${currentEditId}"] .task-text`);
  if (li) li.textContent = newText;
  cancelEdit();
  return false;
}

function cancelEdit() {
  currentEditId = null;
  document.getElementById("edit_task_name").value = "";
  document.getElementById("edit_card").hidden = true;
}

updateTodoList();

