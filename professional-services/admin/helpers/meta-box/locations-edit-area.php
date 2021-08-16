<div class="ps-meta-box">
    <style scoped>
        .ps-meta-box{
            display: grid;
            grid-template-columns: max-content 1fr;
            grid-row-gap: 10px;
            grid-column-gap: 20px;
        }
        .ps-meta-box-field{
            display: contents;
        }
    </style>
    <p class="meta-options ps-meta-box-field">
        <label for="ps-address-1">Address 01</label>
        <input type="text" name="ps-address-1" id="ps-address-1" placeholder="Address 01" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-address-1', true ) ); ?>" />
    </p>
    <p class="meta-options ps-meta-box-field">
        <label for="ps-address-2">Address 02</label>
        <input type="text" name="ps-address-2" id="ps-address-2" placeholder="Address 02" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-address-2', true ) ); ?>" />
    </p>
    <p class="meta-options ps-meta-box-field">
        <label for="country">Country</label>
        <?php $country = get_post_meta( get_the_ID(), 'ps-country', true ); ?>
        <select id="ps-country" class="js-country" name="ps-country">
            <option value="" selected>Select Country</option>           
        </select>
        <span class="hidden"><?php echo $country; ?></span>  
    </p>
    <p class="meta-options ps-meta-box-field">
        <label for="ps-state">State</label>        
        <?php $state = get_post_meta( get_the_ID(), 'ps-state', true ); ?>
        <select id="ps-state" name="ps-state" class="js-state" disabled>
            <option value="" selected>Select a State</option>           
        </select>
        <span class="hidden"><?php echo $state; ?></span>       
    </p>
    <p class="meta-options ps-meta-box-field">
        <label for="ps-city">City</label>
        <?php $city = get_post_meta( get_the_ID(), 'ps-city', true ); ?>
        <select id="ps-city" class="js-city" name="ps-city" disabled>
            <option value="" selected>Select City</option>           
        </select>
        <span class="hidden"><?php echo $city; ?></span>     
    </p>    
    <p class="meta-options ps-meta-box-field">
        <label for="ps-zipcode">Zip Code</label>
        <input type="text" id="ps-zipcode" name="ps-zipcode" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-zipcode', true ) ); ?>" />
    </p>
    <p class="meta-options ps-meta-box-field">
        <label for="ps-phone-number">Phone Number</label>
        <input type="text" id="ps-phone-number" name="ps-phone-number" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-phone-number', true ) ); ?>" />
    </p>
    <p class="meta-options ps-meta-box-field">
        <label for="ps-toll-free-number">Toll Free Phone Number</label>
        <input type="text" id="ps-toll-free-number" name="ps-toll-free-number" value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'ps-toll-free-number', true ) ); ?>" />
    </p>
    <div class="meta-options ps-meta-box-field">
        <label for="ps-image">Image</label>
        <?php $image = get_post_meta( get_the_ID(), 'ps-image', true ); ?>
        <div class="file-uploaded image-uploaded <?php echo $image != null ? '' : 'hidden'; ?>">
            <a href="javascript:void(0);"><i class="fal fa-times-circle"></i></a>
            <img src="<?php echo esc_attr($image); ?>" class="img-fluid ps-image" />
            <input type="hidden" name="ps-image" value="<?php echo esc_attr($image); ?>" class="icon-img" />
        </div>
        <div class="file-upload <?php echo $image ? 'hidden' : ''; ?>">
            <div class="file-upload-add-file add-file add-image">
                <label for="ps-image" data-tooltip="Click To Add File">
                        <i class="fal fa-plus-circle fa-3x"></i>
                </label>
            </div>
        </div>
    </div>

</div>