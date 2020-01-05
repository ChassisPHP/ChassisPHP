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
            <div class="Rtable-cell">{{ album.PublicationDate|date('Y-m-d H:i:s') }}</div>
            <a href="/backend/albums/update/{{ album.ID }}" class="button button-medium blueBackground">Edit</a>
            <a href="/backend/albums/delete/{{ album.ID }}" class="button button-medium redBackground" onclick="return confirm('Are you sure?')">DELETE</a>
            </div>
        </div>
    </div>
</article>
{% endblock %}
