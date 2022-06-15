let add = document.querySelector("form button");
let section = document.querySelector("section");
add.addEventListener("click", (e) => {
  e.preventDefault(); //讓表單不會送出
  console.log(e);

  //取得input的值
  let form = e.target.parentElement; //e.target取得標籤
  let todoText = form.children[0].value;
  let todoMonth = form.children[1].value;
  let todoDate = form.children[2].value;
  console.log(todoText, todoMonth, todoDate);

  //create item
  let todo = document.createElement("div");
  todo.classList.add("todo"); //新增css
  let text = document.createElement("p");
  text.classList.add("todo-text");
  text.innerText = "事件:"+todoText;
  let time = document.createElement("p");
  time.classList.add("todo-time");
  time.innerText = "日期:" + todoMonth + "/" + todoDate;
  todo.appendChild(text);
  todo.appendChild(time);
  section.appendChild(todo);

  let check = document.createElement("button");
  check.classList.add("check");
  check.innerHTML = '<i class="fa-regular fa-circle-check"></i>'; //確認圖標
  let trash = document.createElement("button");
  trash.classList.add("trash");
  trash.innerHTML = '<i class="fa-regular fa-trash-can"></i>'; //垃圾桶圖標
  todo.appendChild(check);
  todo.appendChild(trash);
});
