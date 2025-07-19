// export function updateBlogs(blog) {
//     if (!blog) {
//         return alert("No such blog found.");
//     }

//     console.log("Updating blog:", blog);

//     // Set values in form fields
//     document.querySelector('#titleToUpdate').value = blog.title;
//     document.querySelector('#contentToUpdate').value = blog.content;

//     // Handle hidden input for blog_id
//     let blogIdInput = document.getElementById('blog_id');
//     if (!blogIdInput) {
//         blogIdInput = document.createElement('input');
//         blogIdInput.type = 'hidden';
//         blogIdInput.name = 'blog_id';
//         blogIdInput.id = 'blog_id';
//         document.querySelector('form.blog-form').appendChild(blogIdInput);
//     }

//     blogIdInput.value = blog.blog_id;

//     // Optionally update button text
//     document.querySelector('form.blog-form button[type="submit"]').textContent = "Update";
// }

document.addEventListener("DOMContentLoaded", () => {
    const blog = JSON.parse(localStorage.getItem("blogToEdit"));
    if (blog) {
        document.getElementById("titleToUpdate").value = blog.title;
        document.getElementById("contentToUpdate").value = blog.content;

        let blogIdInput = document.getElementById("blog_id");
        if (!blogIdInput) {
            blogIdInput = document.createElement("input");
            blogIdInput.type = "hidden";
            blogIdInput.name = "blog_id";
            blogIdInput.id = "blog_id";
            document.querySelector(".blog-update-form").appendChild(blogIdInput);
        }
        blogIdInput.value = blog.blog_id;

        localStorage.removeItem("blogToEdit"); // Clean up
    }
});



