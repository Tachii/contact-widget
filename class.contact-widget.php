<?php

class Contact_Widget extends WP_Widget{
        
    //Plugin Constructor
    public function __construct(){
        parent:: __construct(
            'contact_widget', //Base ID
            __('Ajax Contact Widget','text_domain'), //Name
            array('description' => __('Ajax powered contact widget','text_domain'))
        );
    }
    
    //Frontend Display
    public function widget($args, $instance){
        $title = apply_filters('widget_title', $instance['title']);
        $recipient = $instance['recipient'];
        $subject = $instance['subject'];
    
        echo $args['before_widget'];
        if(!empty($title))
            echo $args['before_title'] . $title .$args['after_title'];
        //Display Form
        echo $this->getForm($recipient, $subject);
        echo $args['after_widget'];
    }
    
    //Backend Form
    public function form($instance){
        if(isset($instance['title'])){
            $title = $instance['title'];
        }else{
            $title = __('Ajax Contact Widget','text_domain');
        }
        $recipient = $instance['recipient'];
        $subject = $instance['subject'];
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('recipient'); ?>"><?php _e('recipient:') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('recipient'); ?>" name="<?php echo $this->get_field_name('recipient'); ?>" type="text" value="<?php echo esc_attr($recipient); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('subject'); ?>"><?php _e('subject:') ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('subject'); ?>" name="<?php echo $this->get_field_name('subject'); ?>" type="text" value="<?php echo esc_attr($subject); ?>" />
            </p>
        <?php
        
    }
    
    //Update Method
    public function update($new_instance, $old_instance){
        $instance = array();
        $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : ' ';
        $instance['recipient'] = (! empty($new_instance['recipient'])) ? strip_tags($new_instance['recipient']) : ' ';
        $instance['subject'] = (! empty($new_instance['subject'])) ? strip_tags($new_instance['subject']) : ' ';
        
        return $instance;
    }
    
    //Display Contact Form
    public function getForm($recipient, $subject){
        $output='
        <div id="form-messages"></div>
            <form id="ajax-contact" method="post" action="'.plugins_url().'/contact-widget/mailer.php">
                <div class="field">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required />
                </div>
                
                <div class="field">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required />
                </div>
                
                <div class="field">
                    <label for="message">Message:</label>
                    <textarea  id="message" name="message" required></textarea>
                </div>
                <br />
                <input name="recipient" type="hidden" value="'.$recipient.'" />
                <input name="subject" type="hidden" value="'.$subject.'" />
                <div class="field">
                    <input name="contact_submit" type="submit" value="Send" />
                </div>
            </form>
        ';
        
        return $output;
        
    }
    
}

?>