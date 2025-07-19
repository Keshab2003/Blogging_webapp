// const url = "http://localhost/keshav/get_blogs.php";
// let blogs = [];
// let filteredBlogs = [];
// const blogsPerPage = 5;
// let currentPage = 1;

// document.addEventListener("DOMContentLoaded", () => {
//   const container = document.querySelector(".container-new");
//   const paginationContainer = document.querySelector('.pagination');

//   // ---------------------- Fetching blogs from server ----------------------
//   function fetchResult() {
//     fetch(url)
//       .then((res) => res.json())
//       .then((data) => {
//         if (Array.isArray(data)) {
//           blogs.push(...data);
//           filteredBlogs = [...blogs]; // Set default filter to all blogs
//           renderBlogs(currentPage);
//           renderPagination();
//         } else {
//           console.error("Expected array, got:", typeof data, data);
//         }
//       })
//       .catch((err) => console.error("Fetch error:", err));
//   }

//   fetchResult();

//   // ---------------------- Render blog cards ----------------------
//   function renderBlogs(currentPage) {
//     container.innerHTML = '';

//     const start = (currentPage - 1) * blogsPerPage;
//     const end = start + blogsPerPage;
//     const pageBlogs = filteredBlogs.slice(start, end);

//     pageBlogs.forEach((blog) => {
//       createComponent(blog);
//     });
//   }

//   // ---------------------- Render pagination ----------------------
//   function renderPagination() {
//     const totalPages = Math.ceil(filteredBlogs.length / blogsPerPage);
//     paginationContainer.innerHTML = "";

//     // Prev Button
//     const prev = document.createElement("a");
//     prev.href = "#";
//     prev.innerHTML = "&laquo;";
//     prev.onclick = () => {
//       if (currentPage > 1) {
//         currentPage--;
//         renderBlogs(currentPage);
//         renderPagination();
//       }
//     };
//     paginationContainer.appendChild(prev);

//     // Page Numbers
//     for (let i = 1; i <= totalPages; i++) {
//       const a = document.createElement("a");
//       a.href = "#";
//       a.textContent = i;
//       if (i === currentPage) {
//         a.classList.add("active");
//       }
//       a.onclick = () => {
//         currentPage = i;
//         renderBlogs(currentPage);
//         renderPagination();
//       };
//       paginationContainer.appendChild(a);
//     }

//     // Next Button
//     const next = document.createElement("a");
//     next.href = "#";
//     next.innerHTML = "&raquo;";
//     next.onclick = () => {
//       if (currentPage < totalPages) {
//         currentPage++;
//         renderBlogs(currentPage);
//         renderPagination();
//       }
//     };
//     paginationContainer.appendChild(next);
//   }

//   // ---------------------- Create blog card ----------------------
//   function createComponent(object) {
//     const maindiv = document.createElement("div");
//     maindiv.classList.add("maindiv");

//     const leftdiv = document.createElement("div");
//     leftdiv.classList.add("leftdiv");

//     const img = document.createElement("img");
//     img.classList.add("img");

//     const baseName = object.image;
//     const extensions = ["jpg", "png", "gif", "jpeg"];
//     let found = false;

//     for (let ext of extensions) {
//       const testPath = `/keshav/uploads/${baseName}.${ext}`;
//       const testImg = new Image();
//       testImg.src = testPath;

//       testImg.onload = function () {
//         if (!found) {
//           img.src = testPath;
//           leftdiv.appendChild(img);
//           found = true;
//         }
//       };

//       testImg.onerror = function () {
//         console.warn(`Missing: ${testPath}`);
//       };
//     }

//     const title = document.createElement("div");
//     title.classList.add("blog-title");
//     title.innerText = object.title;
//     leftdiv.appendChild(title);

//     maindiv.appendChild(leftdiv);

//     const rightdiv = document.createElement("div");
//     rightdiv.classList.add("rightdiv");

//     const desc = document.createElement("span");
//     desc.classList.add("desc");
//     desc.innerHTML = object.content;
//     rightdiv.appendChild(desc);

//     const author = document.createElement("span");
//     author.classList.add("author");
//     author.innerHTML = object.username ?? "Unknown";
//     rightdiv.appendChild(author);

//     maindiv.appendChild(rightdiv);
//     container.appendChild(maindiv);
//   }

//   // ---------------------- Search filter (title or author) ----------------------
//   const searchInput = document.getElementById("search-input");
//   if (searchInput) {
//     searchInput.addEventListener("input", (e) => {
//       const term = e.target.value.toLowerCase().trim();

//       filteredBlogs = blogs.filter(blog =>
//         blog.title.toLowerCase().includes(term) ||
//         blog.username?.toLowerCase().includes(term)
//       );

//       currentPage = 1;
//       renderBlogs(currentPage);
//       renderPagination();
//     });
//   }
// });















































const url = "http://localhost/keshav/get_blogs.php";
let blogs = [];
let filteredBlogs = [];
const blogsPerPage = 5;
let currentPage = 1;

document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".container-new");
  const paginationContainer = document.querySelector(".pagination");
  const searchInput = document.querySelector("#search-input");
  const searchButton = document.querySelector("#search-button");

  // Fetch data from PHP
  function fetchBlogs() {
    fetch(url)
      .then((res) => res.json())
      .then((data) => {
        if (Array.isArray(data)) {
          blogs = data;
          filteredBlogs = [...blogs];
          renderBlogs();
          renderPagination();
        } else {
          console.error("Invalid data format:", data);
        }
      })
      .catch((err) => console.error("Fetch error:", err));
  }

  fetchBlogs();

  // Render Blogs
  function renderBlogs() {
    container.innerHTML = "";
    const start = (currentPage - 1) * blogsPerPage;
    const end = start + blogsPerPage;
    const pageBlogs = filteredBlogs.slice(start, end);
    pageBlogs.forEach(createComponent);
  }

  // Render Pagination
  function renderPagination() {
    const totalPages = Math.ceil(filteredBlogs.length / blogsPerPage);
    paginationContainer.innerHTML = "";

    const addPageLink = (label, page) => {
      const a = document.createElement("a");
      a.href = "#";
      a.textContent = label;
      if (page === currentPage) a.classList.add("active");
      a.addEventListener("click", (e) => {
        e.preventDefault();
        currentPage = page;
        renderBlogs();
        renderPagination();
      });
      paginationContainer.appendChild(a);
    };

    if (currentPage > 1) addPageLink("«", currentPage - 1);
    for (let i = 1; i <= totalPages; i++) addPageLink(i, i);
    if (currentPage < totalPages) addPageLink("»", currentPage + 1);
  }

  // Create Blog Card
  function createComponent(blog) {
    const maindiv = document.createElement("div");
    maindiv.classList.add("maindiv");

    const leftdiv = document.createElement("div");
    leftdiv.classList.add("leftdiv");

    const img = document.createElement("img");
    img.classList.add("img");

    const baseName = blog.image;
    const extensions = ["jpg", "png", "gif", "jpeg"];
    for (let ext of extensions) {
      const testPath = `/keshav/uploads/${baseName}.${ext}`;
      const testImg = new Image();
      testImg.src = testPath;
      testImg.onload = () => {
        if (!img.src) {
          img.src = testPath;
          leftdiv.appendChild(img);
        }
      };
    }

    const title = document.createElement("div");
    title.classList.add("blog-title");
    title.innerText = blog.title;
    leftdiv.appendChild(title);

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

    maindiv.appendChild(leftdiv);
    maindiv.appendChild(rightdiv);
    container.appendChild(maindiv);
  }

  // Search Handler
  searchButton.addEventListener("click", () => {
    const key = searchInput.value.trim().toLowerCase();
    filteredBlogs = blogs.filter((blog) =>
      blog.title.toLowerCase().includes(key) ||
      (blog.username ?? "").toLowerCase().includes(key)
    );
    currentPage = 1;
    renderBlogs();
    renderPagination();
  });
});
