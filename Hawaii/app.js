let nav = document.querySelector("nav");
let navAnchor = document.querySelectorAll("nav .nav2 ul li a");
let navh2 = document.querySelector("nav .nav1 h2");
console.log(navAnchor);
console.log(nav);

window.addEventListener("scroll", () => {
  //console.log(window.pageYOffset); //取得滾輪Y的位置 最上方為0
  if (window.pageYOffset != 0) {
    nav.style = "background-color:rgba(0,0,0,0.6);";
    navh2.style = "color:white;";
    navAnchor.forEach((a) => {
      //使用queryselectorall時不可直接使用.style 需使用forEach將每個標籤做修改。
      a.style = "color:white;";
    });
  } else {
    navh2.style = "";
    nav.style = "background-color:white;";
    navAnchor.forEach((a) => {
      //使用queryselectorall時不可直接使用.style 需使用forEach將每個標籤做修改。
      a.style = "color:black;";
    });
  }
});
