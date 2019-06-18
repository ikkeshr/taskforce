<?php
    session_start();

    /*The image can be uploaded directly to the database without
      storing on the server. But it will increase the database size
      and web page load time. So, its always a good idea to upload image
      to the server and store file name in the database. */

      include('../../includes/db_connect.php');

        //File upload path.
        $targetDir = "../../profile_pictures/";
        $fileName = basename($_FILES['file']['name']);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $fileType = strtolower($fileType);

        if(!empty($_FILES['file']['name']))
        {
            //allow certain file formats.
            $allowTypes = array('jpg', 'png', 'jpeg');
            if(in_array($fileType, $allowTypes))
            {

                //delete user old picture.
                //delete pictures that start with the user id. (userId*)
                foreach (glob('../../profile_pictures/'.$_SESSION['pid'].'*.*') as $filename) {
                    unlink($filename);
                }

                //renaming file, the name of the file will be in the following format.
                //format: monthDateYear_HourMinutesSeconds_amOrPm
                date_default_timezone_set(date_default_timezone_get());
                $date = date('mdY_his_a', time());
                $fileName = $_SESSION['pid'] ."_". $date . "." . $fileType;
                $targetFilePath = $targetDir . $fileName;


                //upload file to server.
                if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath))
                {
                    //insert image link into database
                    $sql ="update people SET picture=" . $conn->quote($fileName) . "
                      WHERE pid=" . $_SESSION['pid'];
                    $insert = $conn->exec($sql);
                    $_SESSION['picture'] = $fileName;
                    echo $fileName;
                }else{ echo "File wasn't uploaded";}
            }else{ echo "Invalid file format.";}
        }else{ echo "Please enter an image.";}

        $conn=null;
 ?>
