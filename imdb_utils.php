<?php

class ImdbUtils
{

// Scrape movie information from IMDb page and return results in an array.
    /*public function scrapeMovieInfo($imdbId, $getExtraInfo = true)
    {
    	$imdbUrl = "http://www.imdb.com/title/" . trim($imdbId) . "/";

        $arr = array();
        $html = $this->geturl("${imdbUrl}combined");
        $title_id = $this->match('/<link rel="canonical" href="http:\/\/www.imdb.com\/title\/(tt\d+)\/combined" \/>/ms', $html, 1);
        if(empty($title_id) || !preg_match("/tt\d+/i", $title_id)) {
            $arr['error'] = "No Title found on IMDb!";
            return $arr;
        }
        $arr['title_id'] = $title_id;
        $arr['imdb_url'] = $imdbUrl;
        $arr['title'] = str_replace('"', '', trim($this->match('/<title>(IMDb \- )*(.*?) \(.*?<\/title>/ms', $html, 2)));
        $arr['original_title'] = trim($this->match('/class="title-extra">(.*?)</ms', $html, 1));
        $arr['year'] = trim($this->match('/<title>.*?\(.*?(\d{4}).*?\).*?<\/title>/ms', $html, 1));
        $arr['rating'] = $this->match('/<b>(\d.\d)\/10<\/b>/ms', $html, 1);
        $arr['genres'] = $this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Genre.?:(.*?)(<\/div>|See more)/ms', $html, 1), 1);
        $arr['directors'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Directed by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['writers'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Writing credits<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['cast'] = $this->match_all_key_value('/<td class="nm"><a.*?href="\/name\/(.*?)\/".*?>(.*?)<\/a>/ms', $this->match('/<h3>Cast<\/h3>(.*?)<\/table>/ms', $html, 1));
        $arr['cast'] = array_slice($arr['cast'], 0, 30);
        $arr['stars'] = array_slice($arr['cast'], 0, 5);
        $arr['producers'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Produced by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['musicians'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Original Music by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['cinematographers'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Cinematography by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['editors'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Film Editing by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['mpaa_rating'] = $this->match('/MPAA<\/a>:<\/h5><div class="info-content">Rated (G|PG|PG-13|PG-14|R|NC-17|X) /ms', $html, 1);
        $arr['release_date'] = $this->match('/Release Date:<\/h5>.*?<div class="info-content">.*?([0-9][0-9]? (January|February|March|April|May|June|July|August|September|October|November|December) (19|20)[0-9][0-9])/ms', $html, 1);
        $arr['tagline'] = trim(strip_tags($this->match('/Tagline:<\/h5>.*?<div class="info-content">(.*?)(<a|<\/div)/ms', $html, 1)));
        $arr['plot'] = trim(strip_tags($this->match('/Plot:<\/h5>.*?<div class="info-content">(.*?)(<a|<\/div)/ms', $html, 1)));
        $arr['plot_keywords'] = $this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Plot Keywords:<\/h5>.*?<div class="info-content">(.*?)<\/div/ms', $html, 1), 1);
        $arr['poster'] = $this->match('/<div class="photo">.*?<a name="poster".*?><img.*?src="(.*?)".*?<\/div>/ms', $html, 1);
        $arr['poster_large'] = "";
        $arr['poster_full'] = "";
        if ($arr['poster'] != '' && strpos($arr['poster'], "media-imdb.com") > 0) { //Get large and small posters
            $arr['poster'] = preg_replace('/_V1.*?.jpg/ms', "_V1._SY200.jpg", $arr['poster']);
            $arr['poster_large'] = preg_replace('/_V1.*?.jpg/ms', "_V1._SY500.jpg", $arr['poster']);
            $arr['poster_full'] = preg_replace('/_V1.*?.jpg/ms', "_V1._SY0.jpg", $arr['poster']);
        } else {
            $arr['poster'] = "";
        }
        $arr['runtime'] = trim($this->match('/Runtime:<\/h5><div class="info-content">.*?(\d+) min.*?<\/div>/ms', $html, 1));
        $arr['top_250'] = trim($this->match('/Top 250: #(\d+)</ms', $html, 1));
        $arr['oscars'] = trim($this->match('/Won (\d+) Oscars?\./ms', $html, 1));
        if(empty($arr['oscars']) && preg_match("/Won Oscar\./i", $html)) $arr['oscars'] = "1";
        $arr['awards'] = trim($this->match('/(\d+) wins/ms',$html, 1));
        $arr['nominations'] = trim($this->match('/(\d+) nominations/ms',$html, 1));
        $arr['votes'] = $this->match('/>(\d+,?\d*) votes</ms', $html, 1);
        $arr['language'] = $this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Language.?:(.*?)(<\/div>|>.?and )/ms', $html, 1), 1);
        $arr['country'] = $this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Country:(.*?)(<\/div>|>.?and )/ms', $html, 1), 1);

        if($getExtraInfo == true) {
            $plotPageHtml = $this->geturl("${imdbUrl}plotsummary");
            $arr['storyline'] = trim(strip_tags($this->match('/<p class="plotpar">(.*?)(<i>|<\/p>)/ms', $plotPageHtml, 1)));
            $releaseinfoHtml = $this->geturl("http://www.imdb.com/title/" . $arr['title_id'] . "/releaseinfo");
            $arr['also_known_as'] = $this->getAkaTitles($releaseinfoHtml);
            $arr['release_dates'] = $this->getReleaseDates($releaseinfoHtml);
            $arr['recommended_titles'] = $this->getRecommendedTitles($arr['title_id']);
            $arr['media_images'] = $this->getMediaImages($arr['title_id']);
            $arr['videos'] = $this->getVideos($arr['title_id']);
        }

        return $arr;
    }*/

    public function scrapeMovieInfo($imdbId, $getExtraInfo = true)
    {
    	$imdbUrl = "http://www.imdb.com/title/" . trim($imdbId) . "/";

        $arr = array();
        $html = $this->geturl("${imdbUrl}combined");
        $title_id = $this->match('/<link rel="canonical" href="http:\/\/www.imdb.com\/title\/(tt\d+)\/combined" \/>/ms', $html, 1);
        if(empty($title_id) || !preg_match("/tt\d+/i", $title_id)) {
            $arr['error'] = "No Title found on IMDb!";
            return $arr;
        }
        /*$arr['title_id'] = $title_id;
        $arr['imdb_url'] = $imdbUrl;
        $arr['title'] = str_replace('"', '', trim($this->match('/<title>(IMDb \- )*(.*?) \(.*?<\/title>/ms', $html, 2)));
        $arr['original_title'] = trim($this->match('/class="title-extra">(.*?)</ms', $html, 1));
        $arr['year'] = trim($this->match('/<title>.*?\(.*?(\d{4}).*?\).*?<\/title>/ms', $html, 1));
        $arr['rating'] = $this->match('/<b>(\d.\d)\/10<\/b>/ms', $html, 1);
        $arr['genres'] = $this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Genre.?:(.*?)(<\/div>|See more)/ms', $html, 1), 1);
        $arr['directors'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Directed by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['writers'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Writing credits<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));*/
        $arr['cast'] = $this->match_all_key_value('/<td class="nm"><a.*?href="\/name\/(.*?)\/".*?>(.*?)<\/a>/ms', $this->match('/<h3>Cast<\/h3>(.*?)<\/table>/ms', $html, 1));
        $arr['cast'] = array_slice($arr['cast'], 0, 30);
        $arr['stars'] = array_slice($arr['cast'], 0, 5);
        /*$arr['producers'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Produced by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['musicians'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Original Music by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['cinematographers'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Cinematography by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['editors'] = $this->match_all_key_value('/<td valign="top"><a.*?href="\/name\/(.*?)\/">(.*?)<\/a>/ms', $this->match('/Film Editing by<\/a><\/h5>(.*?)<\/table>/ms', $html, 1));
        $arr['mpaa_rating'] = $this->match('/MPAA<\/a>:<\/h5><div class="info-content">Rated (G|PG|PG-13|PG-14|R|NC-17|X) /ms', $html, 1);
        $arr['release_date'] = $this->match('/Release Date:<\/h5>.*?<div class="info-content">.*?([0-9][0-9]? (January|February|March|April|May|June|July|August|September|October|November|December) (19|20)[0-9][0-9])/ms', $html, 1);
        $arr['tagline'] = trim(strip_tags($this->match('/Tagline:<\/h5>.*?<div class="info-content">(.*?)(<a|<\/div)/ms', $html, 1)));
        $arr['plot'] = trim(strip_tags($this->match('/Plot:<\/h5>.*?<div class="info-content">(.*?)(<a|<\/div)/ms', $html, 1)));
        $arr['plot_keywords'] = $this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Plot Keywords:<\/h5>.*?<div class="info-content">(.*?)<\/div/ms', $html, 1), 1);*/
        $arr['poster'] = $this->match('/<div class="photo">.*?<a name="poster".*?><img.*?src="(.*?)".*?<\/div>/ms', $html, 1);
        $arr['poster_large'] = "";
        $arr['poster_full'] = "";
        if ($arr['poster'] != '' && strpos($arr['poster'], "media-imdb.com") > 0) { //Get large and small posters
            $arr['poster'] = preg_replace('/_V1.*?.jpg/ms', "_V1._SY200.jpg", $arr['poster']);
            $arr['poster_large'] = preg_replace('/_V1.*?.jpg/ms', "_V1._SY500.jpg", $arr['poster']);
            $arr['poster_full'] = preg_replace('/_V1.*?.jpg/ms', "_V1._SY0.jpg", $arr['poster']);
        } else {
            $arr['poster'] = "";
        }
        /*$arr['runtime'] = trim($this->match('/Runtime:<\/h5><div class="info-content">.*?(\d+) min.*?<\/div>/ms', $html, 1));
        $arr['top_250'] = trim($this->match('/Top 250: #(\d+)</ms', $html, 1));
        $arr['oscars'] = trim($this->match('/Won (\d+) Oscars?\./ms', $html, 1));
        if(empty($arr['oscars']) && preg_match("/Won Oscar\./i", $html)) $arr['oscars'] = "1";
        $arr['awards'] = trim($this->match('/(\d+) wins/ms',$html, 1));
        $arr['nominations'] = trim($this->match('/(\d+) nominations/ms',$html, 1));
        $arr['votes'] = $this->match('/>(\d+,?\d*) votes</ms', $html, 1);
        $arr['language'] = $this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Language.?:(.*?)(<\/div>|>.?and )/ms', $html, 1), 1);
        $arr['country'] = $this->match_all('/<a.*?>(.*?)<\/a>/ms', $this->match('/Country:(.*?)(<\/div>|>.?and )/ms', $html, 1), 1);

        if($getExtraInfo == true) {
            $plotPageHtml = $this->geturl("${imdbUrl}plotsummary");
            $arr['storyline'] = trim(strip_tags($this->match('/<p class="plotpar">(.*?)(<i>|<\/p>)/ms', $plotPageHtml, 1)));
            $releaseinfoHtml = $this->geturl("http://www.imdb.com/title/" . $arr['title_id'] . "/releaseinfo");
            $arr['also_known_as'] = $this->getAkaTitles($releaseinfoHtml);
            $arr['release_dates'] = $this->getReleaseDates($releaseinfoHtml);
            $arr['recommended_titles'] = $this->getRecommendedTitles($arr['title_id']);
            $arr['media_images'] = $this->getMediaImages($arr['title_id']);
            $arr['videos'] = $this->getVideos($arr['title_id']);
        }*/

        return $arr;
    }

    private function geturl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $ip=rand(0,255).'.'.rand(0,255).'.'.rand(0,255).'.'.rand(0,255);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/".rand(3,5).".".rand(0,3)." (Windows NT ".rand(3,5).".".rand(0,2)."; rv:2.0.1) Gecko/20100101 Firefox/".rand(3,5).".0.1");
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    private function match_all_key_value($regex, $str, $keyIndex = 1, $valueIndex = 2){
        $arr = array();
        preg_match_all($regex, $str, $matches, PREG_SET_ORDER);
        foreach($matches as $m){
            $arr[$m[$keyIndex]] = $m[$valueIndex];
        }
        return $arr;
    }

    private function match_all($regex, $str, $i = 0){
        if(preg_match_all($regex, $str, $matches) === false)
            return false;
        else
            return $matches[$i];
    }

    private function match($regex, $str, $i = 0){
        if(preg_match($regex, $str, $match) == 1)
            return $match[$i];
        else
            return false;
    }
}

?>