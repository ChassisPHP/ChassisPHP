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
          <input name="name" value="Real Name" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>Username</label>
          <input name="username" value="Username" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>Password</label>
          <input name="passwd" value="password" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>Email</label>
          <input name="email" value="email" class="input-control" />
        </div>
      
        <div class="form-group">
          <label>User Level</label>
          <input name="userLevel" value="3" class="input-control" placeholder="3" style="flex: 6" />    
        </div>
      
        <div class="form-group">
          <label>&nbsp;</label>
          <button type="submit">Save</button>
          <button>Cancel</button>
        </div>
    </form>

</article>
{% endblock %}
