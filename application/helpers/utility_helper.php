<?php

if (! function_exists('active_link')) {
    function active_link($url, $return = 'active') {
        if (is_array($url)) {
            foreach ($url as $u) {
                $u = site_url() . $u;
                if (current_url() == $u) return $return;
            }
        }
        $url = site_url($url);
        return current_url() == $url ? $return : null;
    }
}

function cek_login()
{
    $ci = get_instance();
    if (!$ci->session->has_userdata('login_session')) {
        set_pesan('silahkan login.');
        redirect('auth');
    }
}

// function is_admin()
// {
//     $ci = get_instance();
//     $role = $ci->session->userdata('login_session')['role'];

//     $status = true;

//     if ($role != 'Admin') {
//         $status = false;
//     }

//     return $status;
// }

function set_pesan($pesan, $tipe = true)
{
    $ci = get_instance();
    if ($tipe) {
        $ci->session->set_flashdata('pesan', "<div class='alert alert-success'><strong>SUCCESS!</strong> {$pesan} <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    } else {
        $ci->session->set_flashdata('pesan', "<div class='alert alert-danger'><strong>ERROR!</strong> {$pesan} <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    }
}

// function userdata($field)
// {
//     $ci = get_instance();
//     $ci->load->model('Admin_model', 'admin');

//     $userId = isset($ci->session->userdata('login_session')['admin']);
//     return $ci->admin->get('admin', ['id_adminstaff' => $userId])[$field];
// }

// function nasabahdata($field)
// {
//     $ci = get_instance();
//     $ci->load->model('Admin_model', 'admin');

//     $nasabahId = $ci->session->nasabahdata('login_session')['nasabah'];
//     return $ci->admin->get('nasabah', ['id_user' => $nasabahId])[$field];
// }

// function output_json($data)
// {
//     $ci = get_instance();
//     $data = json_encode($data);
//     $ci->output->set_content_type('application/json')->set_output($data);
// }
