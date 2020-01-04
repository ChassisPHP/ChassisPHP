{% extends 'backend/layout.twig.php' %}
{% block content %}
<article class="container itemCenter center column">

    {% if message.content is defined %}
    <div class="item alert {{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %}

    <header class="item">
        <h1>Albums</h1>
    </header>

    <a href="/backend/albums/create" class="button blueBackground">Add Album</a>
    <div class="item Rtable col90">
        <div class="cell col20">Name</div>
        <div class="cell col10">Created By</div>
        <div class="cell col10">Updated By</div>
        <div class="cell col10">Pub Date</div>
        <div class="cell col10">Last Updated</div>
        <div class="cell col5"></div>
        <div class="cell col5"></div>

        {% for album in albums%}
        <div class="cell col20">{{ album.name }}</div>
        <div class="cell col10">{{ album.CreatedBy.Name }}</div>
        <div class="cell col10">{{ album.UpdatedBy.Name }}</div>
        <div class="cell col10">{{ album.PublicationDate|date('Y-m-d') }}</div>
        <div class="cell col10">{{ album.Updated|date('Y-m-d') }}</div>
        <div class="cell col5"><a href="/backend/albums/{{ album.ID }}">Details</a></div>
        <div class="cell col5"><a href="/backend/albums/delete/{{ album.ID }}" onclick="return confirm('Are you sure?')">Delete</a></div>
        {% endfor %}
    </div>

</article>
{% endblock %}
