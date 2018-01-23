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
    
    <form action="/backend/content/save" method="post"> 
        <div class="form-group">
          <label>Title</label>
          <input name="name" placeholder="Content Title" value="{{ formVars.Title }}" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>Email</label>
          <input name="email" placeholder="Email" value="{{ formVars.email }}" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>Password</label>
          <input name="passwd" placeholder="password" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>User Level</label>
          <input name="userLevel" value="{{ formVars.userLevel }}" class="input-control" placeholder="3" style="flex: 6" />    
        </div>
      
        <div class="form-group">
          <label>&nbsp;</label>
          <button type="submit">Save</button>
          <button>Cancel</button>
        </div>
    </form>
    
    <a href="/backend/content" class="button blueBackground">All Content</a>
    <div class="item">
        <div class="Rtable Rtable--5cols center">
            <div class="Rtable-cell">{{ entryDetails.Id }}</div>
            <div class="Rtable-cell">{{ entryDetails.Title }}</div>
            <div class="Rtable-cell">{{ entryDetails.Body }}</div>
            <div class="Rtable-cell">{{ entryDetails.PublicationDate|date('Y-m-d H:i:s') }}</div>
            <div class="Rtable-cell"><a href="/backend/content/delete/{{ content.ID }}" onclick="return confirm('Are you sure?')">DELETE</a></div>
        </div>
    </div>

</article>
{% endblock %}
