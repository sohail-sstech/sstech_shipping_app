## SSTech Shipping App

### Basic Process
- Shopify store owner goto the Shopify App store and installed SSTech Shipping App.
- The customer comes to the shopify store and browses the list of products. Select product and add to the card and goto check out page. At the time of shipping selection on the checkout page, this App will display different rates as per origin address, destination address and selected products.
- The customer selects our shipping rates. (Those shipping rates calculation at App end)
- The customer submits an order  with selected shipping rates.
- Order create webhook will be called after customer submit order.
- In that webhook call, the system will create a label for particular order and will be sent to the store owner's email address.
- After creating the label, the consignment number will be attached to the order number for the fulfillment process in the shopify store.
- Label order list will display in the App backend and store owners can also download labels from that list.
- Dashboard will display the total no of labels generated today, this week and this month.
- In App settings, store owners can update custom app tokens and receiver email addresses for labels.
- Create Manifest
- Tax calculation
