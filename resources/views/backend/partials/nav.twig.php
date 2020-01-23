<nav class="container blueBackground">
    <ul class="nav item flexStart">
        <li><a href="/">ChassisPHP</a></li>
    </ul>
    <ul class="nav container flexEnd">
        <li><a href="/">Home</a></li>
        <li><a href="/backend/users">Users</a></li>
        <li><a href="/backend/content">Content</a></li>
        <li><a href="/backend/images">Images</a></li>
        <li><a href="/backend/albums">Albums</a></li>
        {% if loggedInUser is defined %}
            <li><a href="/backend/logout">Logout</a></li>
            <li>{{ loggedInUser }}</li>
        {% endif %}
    </ul>
</nav>
