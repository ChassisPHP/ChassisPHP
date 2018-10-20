{% extends 'backend/layout.twig.php' %}
{% block content %} 
<article class="container itemCenter center column">

    {% if message.content is defined %}
    <div class="item alert {{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %} 
    
    <header>
      <h1>Register a new user</h1>
    </header>
  
    
    <form action="/backend/users/register" method="post"> 
        <div class="form-group">
          <label>Name</label>
          <input name="name" placeholder="Real Name" value="{{ formVars.name }}" class="input-control" />
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
          <button onclick="event.preventDefault(); window.location.href='/backend/users'">Cancel</button>
        </div>
    </form>

</article>
{% endblock %}
