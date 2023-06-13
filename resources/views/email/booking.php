<?php foreach ($details as $srows) {
  $dt = explode(" ", $srows->date_time);
?>
  <div style="margin:0;background:rgb(229,229,229);min-height:400px;padding-top:40px">
    <div class="adM">
    </div>
    <div style="width:590px;background:rgb(255,255,255);margin:0 auto 0">
      <div class="adM">
      </div>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
          <tr>
            <td valign="middle" style="margin:5px 0 0;text-align:left;color:rgb(0,0,0);font:14px arial,helvetica,sans-serif;font-weight:bold;padding:17px 35px;background:rgb(249,249,249)">Towtow Booking<br></td>
            <td align="right" style="padding:10px 30px;background:rgb(249,249,249)"><br></td>
          </tr>
        </tbody>
      </table>
      <div style="color:rgb(0,0,0);font:14px arial,helvetica,sans-serif;line-height:18px;padding:20px 35px">
        <div style="margin-bottom:15px;margin-top:10px">Hi <?php echo $name; ?>,<br></div>
        <div style="">
          <div style="font-size:14px;margin-bottom:18px">
            Thank you for placing a request for <?php echo $service; ?> with Tow-Tow.<br>
            Your booking has been accepted and a professional will be assigned to you soon.<br><br>
            <b>Booking Details:</b><br><br>

            Service name: <?php echo $service; ?><br>
            Date: <?php echo $dt[0]; ?><br>
            Time: <?php echo $dt[1]; ?><br>
            Address: <?php echo $srows->pickup_address; ?><br>
            Any Message for Technician: <?php echo $srows->sp_notes; ?><br>
          </div>
          <div style="font-size:14px;margin-bottom:18px">
            Tow Tow L.L.C is not responsible or liable for any accidents or damages incurred by vendors while providing services. Tow Tow L.L.C is a platform that provides a convenient service that allows customers and vendors to connect
          </div>
        </div>
        <div style="font-weight:bold">Thank You,<br></div>
        <div style="font-weight:bold">Team Tow-Tow<br></div>
        <div style="font-weight:bold">
          <div class="yj6qo"></div>
          <div class="adL"><br></div>
        </div>
      </div>
    </div>
  </div>

<?php } ?>