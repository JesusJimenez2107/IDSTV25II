function getTask() {
    const input = document.getElementById("task_name");
    const taskText = input.value.trim();

    if (taskText === "") return false;

    const li = document.createElement("li");
    li.textContent = taskText + " ";

    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Eliminar";
    deleteBtn.onclick = function() {
        li.remove();
        deleteFromStorage(taskText);
    };

    
    li.appendChild(deleteBtn);
    
    document.getElementById("todo_list").appendChild(li);

    saveToStorage(taskText);

    input.value = "";

    return false;
}


function saveToStorage(taskText) {
    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    tasks.push(taskText);
    localStorage.setItem("tasks", JSON.stringify(tasks));
}


function deleteFromStorage(taskText) {
    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    tasks = tasks.filter(t => t !== taskText);
    localStorage.setItem("tasks", JSON.stringify(tasks));
}


function updateTodoList() {
    const list = document.getElementById("todo_list");
    const tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    list.innerHTML = "";

    tasks.forEach(taskText => {
        const li = document.createElement("li");
        li.textContent = taskText + " ";

        const deleteBtn = document.createElement("button");
        deleteBtn.textContent = "Eliminar";
        deleteBtn.onclick = function() {
            li.remove();
            deleteFromStorage(taskText);
        };

        li.appendChild(deleteBtn);
        list.appendChild(li);
    });
}


updateTodoList();