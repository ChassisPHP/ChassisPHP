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
    <form class="item col60" action="{{ action }}" method="{{ method }}" enctype="multipart/form-data">
        <div class="form-group">
          <label>Title</label>
          <input name="title" placeholder="{{ (formVars.title is defined) ? '' : 'Image Title' }}" value="{{ formVars.title }}" class="input-control" />
        </div>

        <div class="form-group">
          <label>Position</label>
          <input name="position" placeholder="{{ (formVars.position is defined) ? '' : 'Position' }}" value="{{ formVars.position }}" class="input-control" />
        </div>

        <div class="form-group">
          <label>Caption</label>
          <textarea name='caption' rows="12" name="body" placeholder="{{ (formVars.caption is defined) ? '' : 'Caption' }}" class="input-control">{{ formVars.caption }}</textarea>
        </div>

        <div class="form-group">
          <label>Album</label>
          <select class="input-control" name="albumId">
            {% for album in albums %}
            <option value="{{ album.id }}"{% if (formVars.albumId is defined) and (formVars.albumId == album.id) %}selected{% endif %}>{{ album.name }}</option>
            {% endfor %}
          </select>
          <br>
        </div>

        <div class="form-group">
          <label>Image Added By</label>
          <input name="createdBy" value="{{ createdBy.name }}" class="input-control" readonly />
          <input type="hidden" name="createdById" value="{{ createdBy.id }}" />
        </div>

        <div class="form-group">
          <label>Image File {{ (action != "/backend/images/create") ? '(leave blank for no change to file)' : '' }}</label>
          <input type="file" name="imageFile" class="input-control" />
        </div>

        <div class="form-group">
          <label>&nbsp;</label>
          <button class="button button-medium greenBackground" type="submit">Save</button>
          <a href="/backend/images" class="button button-medium redBackground">Cancel</a>
        </div>
    </form>

</article>
{% endblock %}
