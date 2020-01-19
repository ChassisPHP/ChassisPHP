{% extends 'backend/layout.twig.php' %}
{% block content %}
<article class="container itemCenter center column">

    {% if message.content is defined %}
    <div class="item alert {{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %}

    <header class="item">
        <h1>Images</h1>
    </header>

    <a href="/backend/images/create" class="button blueBackground">Add Image</a>
    <div class="item Rtable col90">
        <div class="cell col20">Title</div>
        <div class="cell col10">Position</div>
        <div class="cell col20">Album</div>
        <div class="cell col10">Created By</div>
        <div class="cell col10">Updated By</div>
        <div class="cell col10">Pub Date</div>
        <div class="cell col10">Last Updated</div>
        <div class="cell col5"></div>
        <div class="cell col5"></div>

        {% for image in images%}
        <div class="cell col20">{{ image.Title }}</div>
        <div class="cell col10">{{ image.Position }}</div>
        <div class="cell col20">{{ image.Album.Name }}</div>
        <div class="cell col10">{{ image.CreatedBy.Name }}</div>
        <div class="cell col10">{{ image.UpdatedBy.Name }}</div>
        <div class="cell col10">{{ image.PublicationDate|date('Y-m-d') }}</div>
        <div class="cell col10">{{ image.Updated|date('Y-m-d') }}</div>
        <div class="cell col5"><a href="/backend/images/{{ image.ID }}">Details</a></div>
        <div class="cell col5"><a href="/backend/images/delete/{{ image.ID }}" onclick="return confirm('Are you sure?')">Delete</a></div>
        {% endfor %}
    </div>

</article>
{% endblock %}
