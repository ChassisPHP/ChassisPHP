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
        <div class="cell col20">Filename</div>
        <div class="cell col10">Position</div>
        <div class="cell col20">Album</div>
        <div class="cell col10">Created By</div>
        <div class="cell col10">Updated By</div>
        <div class="cell col10">Pub Date</div>
        <div class="cell col10">Last Updated</div>
        <div class="cell col5"></div>
        <div class="cell col5"></div>
        
        {% for content in contents %}
        <div class="cell col20">{{ images.Filename }}</div>
        <div class="cell col10">{{ images.Position }}</div>
        <div class="cell col20">{{ images.Album }}</div>
        <div class="cell col10">{{ images.CreatedBy.Name }}</div>
        <div class="cell col10">{{ images.UpdatedBy.Name }}</div>
        <div class="cell col10">{{ images.PublicationDate|date('Y-m-d') }}</div>
        <div class="cell col10">{{ images.Updated|date('Y-m-d') }}</div>
        <div class="cell col5"><a href="/backend/content/{{ images.ID }}">Details</a></div>
        <div class="cell col5"><a href="/backend/content/delete/{{ images.ID }}" onclick="return confirm('Are you sure?')">Delete</a></div>
        {% endfor %}
    </div>

</article>
{% endblock %}
