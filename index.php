<?php
include("includes/header.php");

$action = GET('action');
switch ($action){
    case 'show_news':
        echo '<a class="backButton" href="'.$home.'"><div class="btn btn-primary m-1 back"><i class="material-icons">chevron_left</i>Xəbərlər</div></a>';
        $id = GET('id');
        $news = News::get($id);
        $user = User::get($news['user_id']);
        title("Xəbərlər - $news[title]");
        echo "
        <div class='col-md-12 d-flex'>
          <div class='col-md-2 news-image'>
            <img src='$home/images/uploads/$news[photo]' alt=''>
          </div>
          <div class='col-md-10'>
            <div class='bg-primary text-center text-white p-1 m-1 b-1'>$news[title]</div>
            <div class='bg-default text-dark p-1'>$news[text]</div>
          </div>
        </div>
        <div class='author'>
          <div>
              Əlavə edən: <span>$user[full_name]</span>
          </div>
           <div>
              Tarix: <span>".date('d.m.Y H:i')."</span>
          </div>
          
        </div>
      
    ";
    break;

    case 'show_category':
        $id = GET('id');
        $category = Category::get($id);
        title("Bölmə - $category[name]");
        echo '
            <div class="all-news">';
        $news = News::getFromCategory($id);
        if(!$news->rowCount())
            echo Errors::alert('Bu bölmədə heç bir xəbər mövcud deyil!');
        foreach ($news as $new) {
            $text = mb_substr($new['title'],0,150).'...';
            echo "
                        <a href='$home/$new[url_name]'>
                            <div class='news-box'>
                                <img src='$home/images/uploads/$new[photo]'>
                                <div class='news-author'>
                                    <span><i class='material-icons'>person</i>Fuad</span>
                                    <span><i class='material-icons'>access_time</i>15:05</span>
                                </div>
                                <div class='news-box-inner'>
                                    $text
                                </div>
                            </div>
                        </a>
                    ";
        }
        echo'
            </div>
        ';
    break;

    default:
        title("Ana Səhifə");
        echo '
            <div class="all-news">';
                $news = News::getAll();
                foreach ($news as $new) {
                    $text = mb_substr($new['title'],0,150).'...';
                    echo "
                        <a href='$home/$new[url_name]'>
                            <div class='news-box'>
                                <img src='$home/images/uploads/$new[photo]'>
                                <div class='news-author'>
                                    <span><i class='material-icons'>person</i>Fuad</span>
                                    <span><i class='material-icons'>access_time</i>15:05</span>
                                </div>
                                <div class='news-box-inner'>
                                    $text
                                </div>
                            </div>
                        </a>
                    ";
                }
                echo'
            </div>
        ';
    break;


}

include("includes/footer.php");
?>
