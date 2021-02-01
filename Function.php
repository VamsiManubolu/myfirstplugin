/* the following code is pasted in C:\xampp\htdocs\wptest\wp-includes\functions.php to work */

<?php
//if user want to change his profile we are filtering  get_avatar function
add_filter( 'get_avatar' , 'my_custom_avatar' , 1 , 5 );
// in the above funtion 1 refer to priority for the event to occur
//5 refer to number of arguments that function(my_custom_avatar) accepts

function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    
    $user = false;

    // Get user by user ID or Mail id

    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );   
    }

    if ( $user && is_object( $user ) ) {

        // get the array of user ids existing in usermeta table

        $id=$user->ID;




        
        //  get the meta value for the userid from usermeta table   
        $avatar =get_user_meta( $id, 'userurl',true );

        // get the img markup

        $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        

    }
    // return our new user avatar
    return $avatar;
}

?>
