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

  if (form.children[0].value === "") {
    alert("請輸入代辦事項!");
    return; //由此結束~
  }

  //create item
  let todo = document.createElement("div");
  todo.classList.add("todo"); //新增css
  let text = document.createElement("p");
  text.classList.add("todo-text");
  text.innerText = "事件:" + todoText;
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

  todo.style.animation = "scaleUp 0.5s forwards";

  check.addEventListener("click", (e) => {
    //確認按鈕觸發事件
    console.log(e.target.parentElement);
    let todoItem = e.target.parentElement;
    todoItem.classList.toggle("done"); //toggle與現在狀態相反,有的化增加反之消除

    //check.style.animation = "toUp 0.5s forwards";
  });
  trash.addEventListener("click", (e) => {
    //垃圾桶觸發事件
    let todoItem = e.target.parentElement;
    console.log(todoItem);
    todoItem.style.animation = "scaleLow 0.5s forwards";
    todoItem.addEventListener("animationend", (e) => {
      //在動畫結束後執行
      let text = todoItem.children[0].innerText;
      let myListArray = JSON.parse(localStorage.getItem("list"));
      myListArray.forEach((item, index) => {
        if (item.todoText == text) {
          //如果這次執行的todoText結果跟所選的事項內容一樣就執行
          myListArray.splice(index, 1); //splice(刪除位置,刪除筆數)
          localStorage.setItem("list", JSON.stringify(myListArray));
        }
      });
      todoItem.remove(); //移除todoItem
    });

    //todoItem.remove();
  });

  let mytodo = {
    // 將資訊存入object裡面
    todoText: todoText,
    todoDate: todoDate,
    todoMonth: todoMonth,
  };

  let myList = localStorage.getItem("list");
  if (myList == null) {
    //如果整個localstorage是空的,就設置一個 key為list value為mytodo
    localStorage.setItem("list", JSON.stringify([mytodo])); //
  } else {
    //如果list裡面已經有存放東西的話
    let myListArray = JSON.parse(myList); //先取得裡面原本的List並使用JSON解析放入myListArray中
    myListArray.push(mytodo); //將新的資訊mytodo放入myListArray
    localStorage.setItem("list", JSON.stringify(myListArray)); //將myListArray使用JSON再次存入至localStorage。
  }

  form.children[0].value = ""; //清空輸入欄位
});

let myList = localStorage.getItem("list"); //取得localstorage裡面的值

if (myList !== "") {
  //若不為空
  let myListArray = JSON.parse(myList);
  myListArray.forEach((item) => {
    //須將物件裡面各項的值取出，所以需要使用forEach
    //將localstorage裡面的值依序加入html
    let todo = document.createElement("div");
    todo.classList.add("todo");
    let text = document.createElement("p");
    text.classList.add("todo-text");
    text.innerText = item.todoText;
    let time = document.createElement("p");
    time.classList.add("todo-time");
    time.innerText = item.todoMonth + "/" + item.todoDate;
    todo.appendChild(text);
    todo.appendChild(time);

    let check = document.createElement("button");
    check.classList.add("check");
    check.innerHTML = '<i class="fa-regular fa-circle-check"></i>'; //確認圖標
    let trash = document.createElement("button");
    trash.classList.add("trash");
    trash.innerHTML = '<i class="fa-regular fa-trash-can"></i>'; //垃圾桶圖標
    todo.appendChild(check);
    todo.appendChild(trash);

    todo.style.animation = "scaleUp 0.5s forwards";

    check.addEventListener("click", (e) => {
      //確認按鈕觸發事件
      console.log(e.target.parentElement);
      let todoItem = e.target.parentElement;
      todoItem.classList.toggle("done"); //toggle與現在狀態相反,有的話增加反之消除

      //check.style.animation = "toUp 0.5s forwards";
    });
    trash.addEventListener("click", (e) => {
      //垃圾桶觸發事件
      let todoItem = e.target.parentElement; //取得該筆資料的父標籤
      console.log(todoItem);
      todoItem.style.animation = "scaleLow 0.5s forwards";
      todoItem.addEventListener("animationend", (e) => {
        //在動畫結束後執行
        let text = todoItem.children[0].innerText;
        let myListArray = JSON.parse(localStorage.getItem("list"));
        myListArray.forEach((item, index) => {
          if (item.todoText == text) {
            //如果這次執行的todoText結果跟所選的事項內容一樣就執行
            myListArray.splice(index, 1); //splice(刪除位置,刪除筆數)
            localStorage.setItem("list", JSON.stringify(myListArray));
          }
        });

        todoItem.remove(); //移除todoItem
      });
    });

    section.appendChild(todo);
  });
}
