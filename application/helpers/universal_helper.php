<?php
defined('BASEPATH') or exit('No direct script access allowed');


function arr_to_obj($data)
{
    return $object = json_decode(json_encode($data), false);
}

function obj_to_arr($data)
{
    return $object = json_decode(json_encode($data), true);
}

function is_url_exist($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);

    return $status;
}

function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;

    return substr($string, $ini, $len);
}

function convert_base64_to_image($text, $dir)
{
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    $doc = new DOMDocument();
    @$doc->loadHTML($text);

    $tags = $doc->getElementsByTagName('img');
    $img = [];
    $i = 0;
    $text_lama = $text;
    foreach ($tags as $tag) {
        $img[$i]['img'] = $tag->getAttribute('src');
        if (strpos($tag->getAttribute('src'), ';base64,') !== false) {
            $image_parts = explode(";base64,", $tag->getAttribute('src'));
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $img[$i]['tipe'] = $image_type;
            $img[$i]['tipe_file'] = tipe($image_type);
            $file = $dir . uniqid() . '.' . tipe($image_type);
            $image_base64 = base64_decode($image_parts[1]);
            file_put_contents($file, $image_base64);
            $img[$i]['file'] = base_url($file);
            $text = str_replace($tag->getAttribute('src'), base_url($file), $text);
            $i++;
        }

    }
    $img['text'] = $text;
    $img['text_lama'] = $text_lama;
    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                if (strpos($text, $entry) != true) {
                    echo $dir . $entry;
                    unlink($dir . $entry);
                    echo $entry;
                }
            }
        }

        closedir($handle);
    }

    return $text;
}

function tipe($tipe)
{
    $tipe = strtolower($tipe);
    switch ($tipe) {
        case "gif":
            return "gif";
            break;
        case "jpeg":
            return "jpg";
            break;
        case "png":
            return "png";
            break;
        default :
            return false;
            break;
    }
}

function getFileExtension($path)
{
    $ext = pathinfo($path, PATHINFO_EXTENSION);

    return $ext;
}

function deleteFiles($directory)
{


    if (substr($directory, strlen($directory) - 1, 1) != '/') {
        $directory .= '/';
    }

    $files = glob($directory . "*");

    if (!empty($files)) {
        foreach ($files as $file) {
            if (is_dir($file)) {
                deleteFiles($file);
            } else {
                unlink($file);
            }
        }
    }
    rmdir($directory);

}

function remove_unsusedp($isi)
{
    $isi = trim($isi);
    $isi = str_replace('&nbsp;', '', $isi);
    $isi = preg_replace('#<o:p>(\s|&nbsp;)*</o:p>#', '', $isi);
    $isi = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $isi);
    $isi = trim($isi);

    return $isi;
}

function DOMinnerHTML(DOMNode $element)
{
    $innerHTML = "";
    $children = $element->childNodes;

    foreach ($children as $child) {
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }

    return $innerHTML;
}

function remove_unsusedhtml($isi)
{
    $isi = trim($isi);
    $isi = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace(['<html>', '</html>', '<body>', '</body>', '<head>', '</head>', '<title>', '</title>'], ['', '', '', '', '', '', '', ''], $isi));;
    $isi = preg_replace('/<!--(.*)-->/Uis', '', $isi);
    $isi = trim($isi);

    return $isi;
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function formatTanggal($tanggal)
{
    $originalDate = $tanggal;
    $date = date("d", strtotime($originalDate));
    $month = date("n", strtotime($originalDate));
    $year = date("Y", strtotime($originalDate));

    $newDate = $date . " " . bulanSingkat[$month] . " " . $year;

    return $newDate;
}

function formatTanggal2($tanggal)
{
    $originalDate = $tanggal;
    $date = date("d", strtotime($originalDate));
    $month = date("n", strtotime($originalDate));
    $year = date("Y", strtotime($originalDate));

    $newDate = $date . " " . bulan[$month] . " " . $year;

    return $newDate;
}

function formatTanggalPembelian($tanggal)
{

}

function getDateString($date)
{
    $dateArray = date_parse_from_format('Y/m/d', $date);
    $monthName = DateTime::createFromFormat('!m', $dateArray['month'])->format('F');
    return $dateArray['day'] . " " . $monthName . " " . $dateArray['year'];
}

function getDateTimeDifferenceString($datetime)
{
    $currentDateTime = new DateTime(date('Y-m-d H:i:s'));
    $passedDateTime = new DateTime($datetime);
    $interval = $currentDateTime->diff($passedDateTime);
    //$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
    $day = $interval->format('%a');
    $hour = $interval->format('%h');
    $min = $interval->format('%i');
    $seconds = $interval->format('%s');

    if ($day > 7)
        return getDateString($datetime);
    else if ($day >= 1 && $day <= 7) {
        if ($day == 1) return $day . " day ago";
        return $day . " days ago";
    } else if ($hour >= 1 && $hour <= 24) {
        if ($hour == 1) return $hour . " hour ago";
        return $hour . " hours ago";
    } else if ($min >= 1 && $min <= 60) {
        if ($min == 1) return $min . " minute ago";
        return $min . " minutes ago";
    } else if ($seconds >= 1 && $seconds <= 60) {
        if ($seconds == 1) return $seconds . " second ago";
        return $seconds . " seconds ago";
    }
}

function rupiah($angka)
{

    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;

}

function alert($level, $title, $message)
{
    $icon = "";
    $class = '';
    switch ($level) {
        case 'success':
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
            $class = "success";
            break;

        case 'info':
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>';
            $class = 'primary';
            break;

        case 'warning':
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>';
            $class = 'warning';
            break;

        case 'danger':
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>';
            $class = 'danger';
            break;
    }

    $_SESSION['alert'][] = "
	<div class=\"alert alert-arrow-left alert-icon-left alert-light-{$class} mb-4\" role=\"alert\">
	<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
		<svg xmlns=\"http://www.w3.org/2000/svg\" data-dismiss=\"alert\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-x close\"><line x1=\"18\" y1=\"6\" x2=\"6\" y2=\"18\"></line><line x1=\"6\" y1=\"6\" x2=\"18\" y2=\"18\"></line></svg>
	</button>
	{$icon}
	<strong>{$title}</strong> {$message}
	</div>
	";
}

function nomorTransaksi($tanggal, $id)
{
    $originalDate = $tanggal;
    $date = date("d", strtotime($originalDate));
    $month = date("m", strtotime($originalDate));
    $year = date("y", strtotime($originalDate));
    $id = sprintf("%04d", $id);
    $newDate = "{$year}{$month}{$date}{$id}";

    return $newDate;
}

function statusTransaksi($status)
{

    switch ($status) {
        case 'belum-bayar':
            return "<span class=\"badge badge-warning\"> BELUM BAYAR </span>";
            break;
        case 'proses':
            return "<span class=\"badge badge-info\"> PROSES DAPUR </span>";
            break;
        case 'selesai':
            return "<span class=\"badge badge-success\"> SUCCESS </span>";
            break;
        case 'batal':
            return "<span class=\"badge badge-danger\"> BATAL </span>";
            break;
        default:
            return "<span class=\"badge badge-dark\"></span>";
            break;
    }

}
