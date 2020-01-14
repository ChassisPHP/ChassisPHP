{% extends 'backend/layout.twig.php' %}
{% block content %}
<article class="container itemCenter center column">

    {% if message.content is defined %}
    <div class="item alert {{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %}

    <header class="item">
        <h1>Album</h1>
    </header>

    <a href="/backend/albums" class="button button-medium blueBackground">All Albums</a>
    <div class="col60">
        <div class="item itemCenter">
            <h1 class="">{{ album.Name }}</h1>
            <p>{{ album.Description }}</p>
            <div class="Rtable-cell">Created: {{ album.createdDate|date('Y-m-d H:i:s') }}</div>
            <div class="Rtable-cell">Updated: {{ album.updated|date('Y-m-d H:i:s') }}</div>
            <h4>Images</h4>
            <div class="Rtable">
              <div class="Rtable-cell col30 bg-grey">Title</div>
              <div class="Rtable-cell col30 bg-grey">Filename</div>
              <div class="Rtable-cell col30"></div>
            {% for image in images %}
              <div class="Rtable-cell col30">{{ image.title }}</div>
              <div class="Rtable-cell col30">{{ image.filename }}</div>
              <div class="Rtable-cell col30"></div>
            {% endfor %}
            </div>
            <a href="/backend/albums/update/{{ album.ID }}" class="button button-medium blueBackground">Edit</a>
            <a href="/backend/albums/delete/{{ album.ID }}" class="button button-medium redBackground" onclick="return confirm('Are you sure?')">DELETE</a>
            </div>
        </div>
    </div>
</article>
{% endblock %}
