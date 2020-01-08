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
    <form class="item col60" action="{{ action }}" method="{{ method }}" enctype="multipart/form-data">
        <div class="form-group">
          <label>Name</label>
          <input name="name" placeholder="{{ (album.Name is defined) ? '' : 'Album Name' }}" value="{{ album.Name }}" class="input-control" />
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea name='description' rows="12" name="body" placeholder="{{ (album.Description is defined) ? '' : 'Description' }}" class="input-control">{{ album.Description }}</textarea>
        </div>

        <div class="form-group">
          <label>Album Added By</label>
          <input name="createdBy" value="{{ createdBy.name }}" class="input-control" readonly />
          <input type="hidden" name="createdById" value="{{ createdBy.id }}" />
        </div>

        <div class="form-group">
          <label>&nbsp;</label>
          <button class="button button-medium greenBackground" type="submit">Save</button>
          <a href="/backend/albums" class="button button-medium redBackground">Cancel</a>
        </div>
    </form>

</article>
{% endblock %}
