{% extends 'backend/layout.twig.php' %}
{% block content %} 
<article class="container itemCenter center column">

    {% if message.content is defined %}
    <div class="item alert {{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %} 
    
    <header class="item">
        <h1>Content</h1>
    </header>
    <form class="item col60" action="{{ action }}" method="{{ method }}"> 
        <div class="form-group">
          <label>Title</label>
          <input name="title" placeholder="{{ (contentEntry.Title is defined) ? '' : 'Content Title' }}" value="{{ contentEntry.Title }}" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>Position</label>
          <input name="position" placeholder="{{ (contentEntry.Position is defined) ? '' : 'Position' }}" value="{{ contentEntry.Position }}" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>Body</label>
          <textarea rows="12" name="body" placeholder="{{ (contentEntry.Body is defined) ? '' : 'Body' }}" class="input-control">{{ contentEntry.Body }}</textarea>
        </div>
      
        <div class="form-group">
          <label>Author</label>
          <input name="authorName" value="{{ author.name }}" class="input-control" readonly />
          <input type="hidden" name="author" value="{{ author.id }}" />
        </div>

        <div class="form-group">
          <label>&nbsp;</label>
          <button class="button button-medium greenBackground" type="submit">Save</button>
          <a href="/backend/content" class="button button-medium redBackground">Cancel</a>
        </div>
    </form>
    
</article>
{% endblock %}
