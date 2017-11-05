{% extends 'backend/layout.twig.php' %}
{% block content %} 
<article class="main-content">

  <header>
    <h1>Register a new user</h1>
  </header>

  
  
  <div class="form-group">
    <label>First Name</label>
    <input value="First Name" class="input-control" />

    <label class="right-inline">Last Name</label>
    <input value="Last Name" class="input-control" />
  </div>

  <div class="form-group">
    <label>Username</label>
    <input value="Username" class="input-control" />
  </div>

  <div class="form-group">
    <label>Password</label>
    <input value="password" class="input-control" />
  </div>

  <div class="form-group">
    <label>User Level</label>
    <input value="3" class="input-control" placeholder="3" style="flex: 6" />    
  </div>

  <div class="form-group">
    <label>&nbsp;</label>
    <button>Save</button>
    <button>Cancel</button>

  </div>

</article>
{% endblock %}
