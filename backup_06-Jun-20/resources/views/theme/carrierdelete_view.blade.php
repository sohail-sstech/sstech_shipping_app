<html>
<header>

<style>	
body {
  margin: 0;
  font-family: "Lato", sans-serif;
}

.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  /*background-color: #f1f1f1;*/
  background-color: #FFFFFF;
  position: fixed;
  height: 100%;
  overflow: auto;
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}
 
.sidebar a.active {
  /*background-color: #4CAF50;*/
  background-color: #000;
  color: white;
}

.sidebar a:hover:not(.active) {
  background-color: #CCCCCC;
  color: white;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
  background-color:#f1f1f1;
  width:100%;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}	
table.a {
  table-layout: auto;
  width: 180px;  
}







thead,
tfoot {
    background-color: #3f87a6;
    color: #fff;
}

tbody {
    background-color: #e4f0f5;
}

caption {
    padding: 10px;
    caption-side: bottom;
}

table {
    border-collapse: collapse;
    border: 2px solid rgb(200, 200, 200);
    letter-spacing: 1px;
    font-family: sans-serif;
    font-size: .8rem;
	width:50%;
}

td,
th {
    border: 1px solid rgb(190, 190, 190);
    padding: 5px 10px;
}

td {
    text-align: center;
}

</style>
</header>
<body>

<div class="sidebar">
  <a href="{{secure_asset('/')}}">Home</a>
  <a class="active"  href="{{secure_asset('/shop')}}">Shop Details</a>
  <a href="{{secure_asset('/products')}}">Product Details</a>
  <a href="{{secure_asset('/orders')}}">Orders Details</a>
</div>
<div class="content">
  <h2>Delete Carrier Service</h2>
  
  <form method="post" action="{{secure_asset('/carrierdelete')}}">
  @csrf
   <label>Please Enter Carrier Service ID : </label>
   <input type="text" name="carrrierid" />
   <input type="submit" name="sbmitbtn" value="Delete Carrier Service" />
  </form>
  
</div>

</body>
</html>