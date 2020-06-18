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
  <a href="{{secure_asset('/shop')}}">Shop Details</a>
  <a href="{{secure_asset('/products')}}">Product Details</a>
  <a class="active"  href="{{secure_asset('/orders')}}">Orders Details</a>
</div>
<div class="content">
  <h2>Shop Data</h2>
  <table>
    <caption>Shop Data Details</caption>
    <thead>
        <tr>
            <th scope="col">Shop Id</th>
			<th scope="col">Shop Name</th>
			<th scope="col">Shop Email</th>
			<th scope="col">Shop Province</th>
			<th scope="col">Shop Address</th>
			<th scope="col">Shop PostalCode</th>
			<th scope="col">Shop Country</th>
			<th scope="col">Shop City</th>
			<th scope="col">Shop Phone</th>
			<th scope="col">Shop Country Code</th>
			<th scope="col">Shop Country Name</th>
			<th scope="col">Shop Currency</th>
			<th scope="col">Shop Customer Email</th>
        </tr>
    </thead>
    <tbody>
        <tr>
			 <td>{{  $shop_id }}</td>
			 <td>{{ $shop_name }}</td>
			 <td>{{ $shop_email }}</td>
			 <td>{{ $shop_province }}</td>
			 <td>{{ $shop_address1 }}</td>
			 <td>{{ $shop_zip }}</td>
			 <td>{{ $shop_country }}</td>
			 <td>{{ $shop_city }}</td>
			 <td>{{ $shop_phone }}</td>
			 <td>{{ $shop_country_code }}</td>
			 <td>{{ $shop_country_name }}</td>
			 <td>{{ $shop_currency }}</td>
			 <td>{{ $shop_customer_email }}</td>
        </tr>
    </tbody>
</table>
  <!-- <table border="1" class="a">
    <tr>
	<th>Shop Id</th>
	<th>Shop Name</th>
	<th>Shop Email</th>
	<th>Shop Province</th>
	<th>Shop Address</th>
	<th>Shop PostalCode</th>
	<th>Shop Country</th>
	<th>Shop City</th>
	<th>Shop Phone</th>
	<th>Shop Country Code</th>
	<th>Shop Country Name</th>
	<th>Shop Currency</th>
	<th>Shop Customer Email</th>
   </tr>
   <tr>
	 <td>{{ $shop_id }}</td>
	 <td>{{ $shop_name }}</td>
	 <td>{{ $shop_email }}</td>
	 <td>{{ $shop_province }}</td>
	 <td>{{ $shop_address1 }}</td>
	 <td>{{ $shop_zip }}</td>
	 <td>{{ $shop_country }}</td>
	 <td>{{ $shop_city }}</td>
	 <td>{{ $shop_phone }}</td>
	 <td>{{ $shop_country_code }}</td>
	 <td>{{ $shop_country_name }}</td>
	 <td>{{ $shop_currency }}</td>
	 <td>{{ $shop_customer_email }}</td>
    </tr>
  </table> -->
</div>





<!--<div class="container">
  <h2>Responsive Tables Using LI <small>Triggers on 767px</small></h2>
</div>-->
</body>
</html>