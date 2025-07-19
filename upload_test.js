export function updateBlogs(blog) {
    if (!blog) {
        return alert("No such blog found.");
    }

    console.log("Updating blog:", blog);

    // Set values in form fields
    document.querySelector('#title').value = blog.title;
    document.querySelector('#content').value = blog.content;

    // Handle hidden input for blog_id
    let blogIdInput = document.getElementById('blog_id');
    if (!blogIdInput) {
        blogIdInput = document.createElement('input');
        blogIdInput.type = 'hidden';
        blogIdInput.name = 'blog_id';
        blogIdInput.id = 'blog_id';
        document.querySelector('form.blog-form').appendChild(blogIdInput);
    }

    blogIdInput.value = blog.blog_id;

    // Optionally update button text
    document.querySelector('form.blog-form button[type="submit"]').textContent = "Update";
}
