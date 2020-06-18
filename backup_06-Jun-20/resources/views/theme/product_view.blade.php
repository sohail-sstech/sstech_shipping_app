 <body-html><![CDATA[index &lt; 0.3]]></body-html>
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

.customlaebl { 
float:left;
}
.customspan{
	display:block;
	overflow:hidden;
	padding:0 4px 0 6px;
	width:100%
}
</style>
</header>
<body>

<div class="sidebar">
  <a href="{{secure_asset('/')}}">Home</a>
  <a href="{{secure_asset('/shop')}}">Shop Details</a>
  <a class="active" href="{{secure_asset('/products')}}">Product Details</a>
  <a href="{{secure_asset('/order')}}">Orders Details</a>
</div>
<div class="content">
	<h2>Shop Data</h2>
	<table>
		<caption>Shop Data Details</caption>
		<thead>
			<tr>
				<th scope="col">Product Id</th>
				<th scope="col">Product Title</th>
				<th scope="col">Product Vendor</th>
				<th scope="col">Product CreatedAt</th>
				<th scope="col">Product Published Scope</th>
				<th scope="col">Product Variants</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($details as $object)
			<tr>
				 <td> {{ $object->id }}</td>
				 <td>{{ $object->title }}</td>
				 <td>{{ $object->vendor }}</td>
				 <td>{{ $object->created_at }}</td>
				 <td>{{ $object->published_scope }}</td>
				 <td>
					@foreach ($object->variants as $variantobj)
					<table style="width:100%;display: table;">
					<tr><td><label class="customlaebl">Id:</label> <span class="customspan">{{ $variantobj->id }} </span></td></tr>
					<tr><td><label class="customlaebl">Product_Id :</label> <span class="customspan">{{ $variantobj->product_id }}</span></td></tr>
					<tr><td><label class="customlaebl">Product_Title:</label><span class="customspan">{{ $variantobj->title }}</span></td></tr>
					<tr><td><label class="customlaebl">Product_Price :</label><span class="customspan">{{ $variantobj->price }}</span></td></tr>
					</table>
					</br>
					@endforeach
				 </td>
				
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
<!--<div class="container">
  <h2>Responsive Tables Using LI <small>Triggers on 767px</small></h2>
</div>-->
</body>
</html>