// views/js/edit/showSidebar.js

function showSidebar() {
  const elmShowSidebar = document.getElementById("showSidebar");
  if (!elmShowSidebar) return;

  elmShowSidebar.addEventListener("click", (e) => {
    const link = e.target.closest("a"); // Tìm thẻ a gần nhất với điểm click
    if (link) {
      e.preventDefault();
      console.log("Click thành công thông qua Delegation!");
    }
  });
}

export {showSidebar}