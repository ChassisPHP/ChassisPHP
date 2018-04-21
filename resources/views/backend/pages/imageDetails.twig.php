{% extends 'backend/layout.twig.php' %}
{% block content %} 
<article class="container itemCenter center column">

    {% if message.content is defined %}
    <div class="item alert {{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %} 
    
    <header class="item">
        <h1>Image</h1>
    </header>
    
    <a href="/backend/images" class="button button-medium blueBackground">All Images</a>
    <div class="col60">
        <div class="item itemCenter">
            <!-- TODO add ln -sr storage/app/public public/storage to documentation -->
            <img src="{{ baseURL }}storage/img/{{ image.Filename }}" />
        </div>
        <div class="item itemCenter">
            <h1 class="">{{ image.Title}}</h1>
            <p>{{ image.Caption }}</p>
            <div class="Rtable-cell">{{ image.PublicationDate|date('Y-m-d H:i:s') }}</div>
            <a href="/backend/images/update/{{ image.ID }}" class="button button-medium blueBackground">Edit</a>
            <a href="/backend/images/delete/{{ image.ID }}" class="button button-medium redBackground" onclick="return confirm('Are you sure?')">DELETE</a>
            </div>
        </div>
    </div>
</article>
{% endblock %}
