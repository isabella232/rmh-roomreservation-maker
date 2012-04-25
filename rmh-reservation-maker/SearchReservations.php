<?php

session_start();
session_cache_expire(30);

$title = "Search Reservations";

include('header.php');
include(ROOT_DIR.'/database/dbReservation.php');
//include(ROOT_DIR.'/navigation.php');

$showReservation = false;

    if(isset($_POST['form_token']) && validateTokenField($_POST))
    {
        $showReservation = true;
   
    }
    
    else if(isset($_POST['form_token']) && !validateTokenField($_POST))
    {
      
        echo('The request could not be completed: security check failed!');

    }
    else
    {
       
    }
     
    
    function searchForReservations()
    {
        $type = ($_POST['searchType']);
        
        if ($type=="Select Search Type")
        {
            echo ("Please choose what you're searching for from the drop down menu below.");
        }
        
        else if ($type=="Request ID")
        {                       
            $roomReservationRequestId = ($_POST["searchParam"]);
            $Reservations = retrieve_RoomReservationActivity_byRequestId($roomReservationRequestId);
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
        else if ($type=="Social Worker (Last Name)")
        {
            $socialWorkerLastName = ($_POST["searchParam"]);
            $Reservations = array();
            $Reservations = (retrieve_SocialWorkerLastName_RoomReservationActivity($socialWorkerLastName));
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
        else if ($type=="Staff Approver (Last Name)")
        {
            $rmhStaffLastName = ($_POST["searchParam"]);
            $Reservations = array();
            $Reservations = (retrieve_RMHStaffLastName_RoomReservationActivity($rmhStaffLastName));
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
        else if ($type=="Family (Last Name)")
        {
            $parentLastName = ($_POST["searchParam"]);
            $Reservations = array();
            $Reservations = (retrieve_FamilyLastName_RoomReservationActivity($parentLastName));
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
        else if ($type=="Status")
        {
            $status = ($_POST["searchParam"]);
            $Reservations = array();
            $Reservations = (retrieve_RoomReservationActivity_byStatus($status));
            return $Reservations;
            
            if (!$Reservations)
            {
                echo ("No reservations found! Try entering your search again.");
            }
        }
        
    }

?>

<div id="container">

    <div id="content">
        
       <form name="SearchReservations" method="post" action="SearchReservations.php">
            <?php echo generateTokenField(); ?>
           
           <select name="searchType">
               <option value = "Select Search Type">Select Search Type</option>
               <option value = "Request ID">Request ID</option>
               <option value = "Social Worker (Last Name)">Social Worker (Last Name)</option>
               <option Value = "Staff Approver (Last Name)">Staff Approver (Last Name)</option>
               <option value = "Family (Last Name)">Family (Last Name)</option>
               <option value = "Status">Status</option>
           </select>
           
           <input type="text" name="searchParam" value="" size="10" />
           
           
           <br>
           <br>
           
           <input type="submit" value="Search" name="enterSearch" />
           
       </form>
        <?php
        if ($showReservation == true)
        {
            $type = $_POST['searchType'];
            $foundReservations = searchForReservations();
            
            if(empty($foundReservations))
            {
                echo "<br>No data matches your selections ";
            
            }
            else
            {
       
        echo '<br>';
        
        echo '<br><br>
            <table border = "2" cellspacing = "10" cellpadding = "10">';       
        echo '<thead>
            <tr>
            <th>Request ID</th>
            <th>Staff  Name</th>
           <th>Parent  Name</th>
           <th>Date Status sumbitted</th>
           <th>Begin Date</th>
           <th>End Date</th>
           <th>Status</th>
           
            </thead>
            <tbody>';
        
        if($type=="Request ID")
        {
        $rmhRequestID= $foundReservations->get_roomReservationRequestID();
        $rmhStaffName = $foundReservations->get_rmhStaffLastName().", ".$foundReservations->get_rmhStaffFirstName();
       $rmhparentName= $foundReservations->get_parentLastName().", ".$foundReservations->get_parentFirstName();
       $rmhDatasubmit = $foundReservations->get_rmhDateStatusSubmitted();
       $rmhbeginDate=$foundReservations->get_beginDate();
       $rmhEndDate=$foundReservations->get_endDate();
       $rmhStatus = $foundReservations->get_status();
       
       echo '<tr>';
       echo '<td>'.$rmhRequestID.'</td>';
       echo '<td>'.$rmhStaffName.'</td>';
       echo '<td>'.$rmhparentName.'</td>';
       echo '<td>'.$rmhDatasubmit.'</td>';
       echo '<td>'.$rmhbeginDate.'</td>';
       echo '<td>'.$rmhEndDate.'</td>';
       echo '<td>'.$rmhStatus.'</td>';
       
     
      
       echo '</tr>';
       
        }
        else
        {

       foreach($foundReservations as $reservation)
       {
           
        $rmhRequestID= $reservation->get_roomReservationRequestID();
        $rmhStaffName = $reservation->get_rmhStaffLastName().", ".$reservation->get_rmhStaffFirstName();
        $rmhparentName= $reservation->get_parentLastName().", ".$reservation->get_parentFirstName();
        $rmhDatasubmit=$reservation->get_rmhDateStatusSubmitted();
        $rmhbeginDate=$reservation->get_beginDate();
        $rmhEndDate=$reservation->get_endDate();
        $rmhStatus = $reservation->get_status();
      
       
       echo '<tr>';
       echo '<td>'.$rmhRequestID.'</td>';
       echo '<td>'.$rmhStaffName.'</td>';
       echo '<td>'.$rmhparentName.'</td>';
       echo '<td>'.$rmhDatasubmit.'</td>';
       echo '<td>'.$rmhbeginDate.'</td>';
       echo '<td>'.$rmhEndDate.'</td>';
       echo '<td>'.$rmhStatus.'</td>';
      
       
      
       echo '</tr>';
       
       
       
        }
        
        echo '</table>';
        }
        }
        }
        ?>

    </div>
</div>
<?php 
include ('footer.php');
?>

