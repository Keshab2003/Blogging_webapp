const url = "http://localhost/php_programming/keshav/get_blogs.php";
 
let blogs = [];
const blogsPerPage = 5;
let currentPage = 1;
let filteredBlogs = [];

document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".container-new");
  const paginationContainer = document.querySelector('.pagination');
  const searchForm = document.getElementById("search-form");
  const searchInput = document.getElementById("search-input");
  

  // Fetch data
  function fetchResult() {
    fetch(url)
      .then((res) => res.json())
      .then((data) => {
        if (Array.isArray(data)) {
          blogs = [...data];
          filteredBlogs = [...blogs];
          renderBlogs(currentPage);
          renderPagination();
        } else {
          console.error("Expected array, got:", typeof data, data);
        }
      })
      .catch((err) => console.error("Fetch error:", err));
  }

  fetchResult();

  // Render blogs
  function renderBlogs(currentPage) {
    container.innerHTML = '';
    const start = (currentPage - 1) * blogsPerPage;
    const end = start + blogsPerPage;
    const pageBlogs = filteredBlogs.slice(start, end);


     if (pageBlogs.length === 0) {
      
      const messageWrapper = document.createElement("div");
      messageWrapper.style.display = "flex";
      messageWrapper.style.justifyContent = "center";
      messageWrapper.style.alignItems = "center";
      messageWrapper.style.marginTop = "40px"; 
      messageWrapper.style.marginBottom = "40px";
      
      const message = document.createElement("p");
      message.textContent =
        "No Blogs avaliable for the request made. redirecting to the dashboard...";
      message.style.color = "red";
      message.style.fontSize = "18px";
      message.style.fontWeight = "bold";
      message.style.backgroundColor = "#fff3f3";
      message.style.padding = "10px 20px";
      message.style.border = "1px solid red";
      message.style.borderRadius = "8px";
      message.style.textAlign = "center";

      messageWrapper.appendChild(message);
      container.appendChild(messageWrapper);

      
 
      setTimeout(() => {
        location.href = "/keshav/blogs.php";
      }, 5000);

      return;
    }




    pageBlogs.forEach(blog => createComponent(blog));
  }

  // Render pagination
  function renderPagination() {
    const totalPages = Math.ceil(filteredBlogs.length / blogsPerPage);
    paginationContainer.innerHTML = "";

    const prev = document.createElement("a");
    prev.href = "#";
    prev.innerHTML = "&laquo;";
    prev.onclick = () => {
      if (currentPage > 1) {
        currentPage--;
        renderBlogs(currentPage);
        renderPagination();
      }
    };
    paginationContainer.appendChild(prev);

    for (let i = 1; i <= totalPages; i++) {
      const a = document.createElement("a");
      a.href = "#";
      a.textContent = i;
      if (i === currentPage) a.classList.add("active");
      a.onclick = () => {
        currentPage = i;
        renderBlogs(currentPage);
        renderPagination();
      };
      paginationContainer.appendChild(a);
    }

    const next = document.createElement("a");
    next.href = "#";
    next.innerHTML = "&raquo;";
    next.onclick = () => {
      if (currentPage < totalPages) {
        currentPage++;
        renderBlogs(currentPage);
        renderPagination();
      }
    };
    paginationContainer.appendChild(next);
  }

  // Search functionality
  // Ensure searchForm is not null before adding event listener
  
  if (searchForm) { // Add this check
    searchForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const key = searchInput.value.trim().toLowerCase();
      filteredBlogs = blogs.filter(blog =>
        blog.title.toLowerCase().includes(key) ||
        (blog.username ?? "").toLowerCase().includes(key)
      );

      currentPage = 1;
      renderBlogs(currentPage);
      renderPagination();
    });
  }


  // Create blog card
  function createComponent(blog) {
    const maindiv = document.createElement("div");
    maindiv.classList.add("maindiv");

    const leftdiv = document.createElement("div");
    leftdiv.classList.add("leftdiv");

    const img = document.createElement("img");
    img.classList.add("img");
    const baseName = blog.image;
    const extensions = ["jpg", "png", "gif", "jpeg"];
    let found = false;

    for (let ext of extensions) {
      const testPath = `/keshav/uploads/${baseName}.${ext}`;
      const testImg = new Image();
      testImg.src = testPath;

      testImg.onload = function () {
        if (!found) {
          img.src = testPath;
          leftdiv.appendChild(img);
          found = true;
        }
      };

      testImg.onerror = function () {
        console.warn(`Missing: ${testPath}`);
      };
    }

    const title = document.createElement("div");
    title.classList.add("blog-title");
    title.innerText = blog.title;
    title.style.textDecoration = "underline";
    title.style.color = "#4775d1";
    leftdiv.appendChild(title);
    maindiv.appendChild(leftdiv);

    const rightdiv = document.createElement("div");
    rightdiv.classList.add("rightdiv");

    const desc = document.createElement("span");
    desc.classList.add("desc");
    desc.innerHTML = blog.content;
    rightdiv.appendChild(desc);

    const author = document.createElement("span");
    author.classList.add("author");
    author.innerHTML = blog.username ?? "Unknown";
    rightdiv.appendChild(author);

    maindiv.appendChild(rightdiv);
    container.appendChild(maindiv);
  }
});