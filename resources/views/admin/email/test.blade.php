<!DOCTYPE html>
<html>
<head>
    <title>steamhouse.com</title>

</head>
<body>
  
   
    <body> 
        <h1>{{ $details['title'] }}</h1> 
        <table cellspacing="0"> 
            <tr> 
            <p>{{ $details['body'] }}</p>
            </tr> 
        </table> 

            <tr>
                 <th>Company Name:=</th>
                <td>{{ $details['user_id'] }}</td>
                </tr>
                <tr>
                <th>Service Request:=</th>
                <td>{{$details['Service_request']}}</td>
                </tr>
                <tr>
                  <th>Date:=</th>
                <td>{{ $details['date'] }}</td>
                </tr>
                <tr>
                   <th>Time:=</th>
                <td>{{ $details['time'] }}</td>
            </tr>

              <tr>
                   <th>Location:=</th>
                <td>{{ $details['company_address'] }}</td>
            </tr>


        <table>



        </table>


    </body> 

    <p>Thank you</p>
</body>
</html>