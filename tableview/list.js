const url = "http://localhost/php_programming/keshav/tableview/table.php"; 
// const url = "/php_programming/keshav/tableview/table.php";

const deleteUrl = "http://localhost/php_programming/keshav/tableview/delete.php";
let tablecontent = [];
const listPerPage = 5;
let currentPage = 1;
let filteredList = [];

import { updateBlogs } from "../upload_test.js";

document.addEventListener("DOMContentLoaded", () => {
  const tableContainer = document.querySelector("#blogTable tbody");
  const paginationContainer = document.querySelector(".pagination");
  const searchInput = document.querySelector("#search-input");
  const searchForm = document.querySelector("#search-form");

  // ---------------------fetch result-----------------------------------------------------------------------------
  function fetchResult() {
    fetch(url)
    // fetch("/php_programming/keshav/tableview/table.php")
      .then((res) => res.json())
      .then((data) => {
        if (Array.isArray(data)) {
          // tablecontent.push(...data); // delete or update will not be update after only being click as this adds on prev value so keeps to duplicate as well
          tablecontent = data; // but this replaces
          filteredList = tablecontent;
          tableContainer.innerHTML = "";
          tablecontent.forEach((blog) => {
            // createComponent(blog);
            renderList(currentPage);
            renderPagination();
          });
        } else {
          renderList(currentPage);
          console.error("Expected array, got:", typeof data, data);
        }
      })
      .catch((err) => {
        console.log(err);
      });
  }

  fetchResult();

  // -----------------------search form----------------------------------------------------------------------------------------

  if (searchForm) {
    searchForm.addEventListener("submit", (e) => {
      e.preventDefault();
      e.preventDefault();

      const key = searchInput.value.trim().toLowerCase();
      filteredList = tablecontent.filter((blog) =>
        blog.title.toLowerCase().includes(key)
      );

      if (filteredList.length === 0) {
        alert(
          "You haven't created any blog yet.\nRedirecting you to the create blog page..."
        );
        window.location.href = "/php_programming/keshav/blog_upload.php"; // Change to your actual blog creation page
        return;
      }

      currentPage = 1;
      renderList(currentPage);
      renderPagination();
    });
  }

  // -----------------------render blogs-------------------------------------------------------------------------------------
  function renderList(currentPage) {
    tableContainer.innerHTML = "";
    const start = (currentPage - 1) * listPerPage;
    const end = start + listPerPage;

    const pageBlogs = filteredList.slice(start, end);

    if (pageBlogs.length === 0) {
      
      const messageWrapper = document.createElement("div");
      messageWrapper.style.display = "flex";
      messageWrapper.style.justifyContent = "center";
      messageWrapper.style.alignItems = "center";
      messageWrapper.style.marginTop = "40px"; 
      messageWrapper.style.marginBottom = "40px";
      messageWrapper.style.marginLeft="60%";

      const message = document.createElement("p");
      message.textContent =
        "You haven't created any blog yet. Redirecting to create blog page...";
      message.style.color = "red";
      message.style.fontSize = "18px";
      message.style.fontWeight = "bold";
      message.style.backgroundColor = "#fff3f3";
      message.style.padding = "10px 20px";
      message.style.border = "1px solid red";
      message.style.borderRadius = "8px";
      message.style.textAlign = "center";

      messageWrapper.appendChild(message);
      tableContainer.appendChild(messageWrapper);
       
 
      setTimeout(() => {
        location.href = "/php_programming/keshav/blog_upload.php";
      }, 5000);

      return;
    }
    pageBlogs.forEach((blog) => createComponent(blog));
  }

  // -----------------------render pagination-------------------------------------------------------------------------------------
  function renderPagination() {
    paginationContainer.innerHTML = "";
    const totalPages = Math.ceil(filteredList.length / listPerPage);

    const prev = document.createElement("a");
    prev.href = "#";
    prev.innerHTML = "&laquo;";
    prev.onclick = () => {
      if (currentPage > 1) {
        currentPage--;
        renderList(currentPage);
        renderPagination();
      }
    };

    paginationContainer.appendChild(prev);

    for (let i = 1; i <= totalPages; i++) {
      const a = document.createElement("a");
      a.href = "#";
      a.textContent = i;
      if (i === currentPage) {
        a.classList.add("active");
      }
      a.onclick = () => {
        currentPage = i;
        renderList(currentPage);
        renderPagination();
      };
      paginationContainer.appendChild(a);
    }

    const next = document.createElement("a");
    next.href = "#";
    next.innerHTML = "&laquo";
    next.onclick = () => {
      if (currentPage < totalPages) {
        currentPage++;
        renderList(currentPage);
        renderPagination();
      }
    };
    paginationContainer.appendChild(next);
  }

  // ---------------------Create component-----------------------------------------------------------------------------
  let update = true;
  function createComponent(blog) {
    const row = document.createElement("tr");

    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Delete";
    deleteBtn.classList.add("del");
    deleteBtn.addEventListener("click", () => {
      deleteBlog(blog.blog_id);
    });

    const updateBtn = document.createElement("button");
    updateBtn.textContent = "Update";
    updateBtn.classList.add("upd");
    // updateBtn.addEventListener("click" , () => {
    //     updateBlogs(blog);
    //     update = true;
    // })
    updateBtn.addEventListener("click", () => {
      localStorage.setItem("blogToEdit", JSON.stringify(blog));
      window.location.href = "./update.php"; // or wherever your form is
    });

    row.innerHTML = `
              <td>${blog.title}</td>
              <td>${blog.content}</td>
              <td>${blog.image}</td>
              <td>${blog.last_update_at}</td>
              <td class="btncell"></td>
            `;

    const btncell = row.querySelector(".btncell");
    btncell.appendChild(deleteBtn);
    btncell.appendChild(updateBtn);

    tableContainer.appendChild(row);
    // if(update){
    //     update = false;
    //     header("Location: update.php");
    // }
  }

  // -----------------delete function-----------------------------------------------------------------
  function deleteBlog(blog_id) {
    if (!confirm("Are you sure ? \n You want to delete this blog. ")) return;

    fetch(`${deleteUrl}?blog_id=${blog_id}`, { method: "GET" })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          alert("Blog deleted Successfully . ");
          fetchResult();
        } else {
          alert("Failed to delete blog . ");
        }
      })
      .catch((err) => {
        console.error("Delete failed:", err);
      });
  }
});
