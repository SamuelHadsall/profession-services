<select name="ps-clients" id="clients" class="js-clients">
    <?php
    $client_args = array(
        'numberposts' => -1,
        'post_type' => 'clients',
    );

    $client_query = get_posts( $client_args );

    if (!empty($client_query)) {
        foreach ($client_query as $client) {

            $id = $client->ID;
            $client_name = $client->post_title;

            echo '<option id="' . str_replace(' ', '-', strtolower($client_name)) . '-' . $id . '" value="' . $id . '"' . selected( $clients, $id ) . '>' . $client_name . '</option>';
        }
    }
    ?>
</select>