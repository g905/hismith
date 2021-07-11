<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsParserController extends Controller {

    public function makeRequest() {
        $nr = new NewsRequestController("http://static.feed.rbc.ru/rbc/logical/footer/news.rss");
        $response = $nr->send();

        if ($response->successful()) {
            //return $this->parse($response);
            return $this->parseUnique($response);
        } else {
            throw new Exception("Fail request");
        }
    }

    public function parse($response) {
        $content = $response->body();
        $rss = simplexml_load_string($content);
        foreach ($rss->channel[0]->item as $item) {
            $newsItem = new \App\Models\NewsItem();
            $newsItem->title = (string) $item->title;
            $newsItem->link = (string) $item->link;
            $newsItem->description = (string) $item->description;
            $newsItem->pubDate = \Illuminate\Support\Carbon::parse($item->pubDate);
            $newsItem->author = (string) $item->author;
            $images = [];
            foreach ($item->enclosure as $img) {
                $images[] = $img["url"];
            }
            $newsItem->image = $this->handleImages($images);
            if ($newsItem->save()) {
                dump("Success: " . $newsItem->title);
            }
        }
        return $response;
    }

    public function parseUnique($response) {
        $content = $response->body();
        $rss = simplexml_load_string($content);
        $count = 0;
        foreach ($rss->channel[0]->item as $item) {
            if (count(\App\Models\NewsItem::where("title", (string) $item->title)->get())) {
                //dump("Skipping existing item: " . (string) $item->title);
                continue;
            }
            $newsItem = new \App\Models\NewsItem();
            $newsItem->title = (string) $item->title;
            $newsItem->link = (string) $item->link;
            $newsItem->description = (string) $item->description;
            $newsItem->pubDate = \Illuminate\Support\Carbon::parse($item->pubDate);
            $newsItem->author = (string) $item->author;
            $images = [];
            foreach ($item->enclosure as $img) {
                $images[] = $img["url"];
            }
            $newsItem->image = $this->handleImages($images);

            if ($newsItem->save()) {
                //dump("Success: " . $newsItem->title);
                $count++;
            }
        }
        $res["success"] = true;
        $res["count"] = $count;
        return $res;
    }

    private function handleImages($images) {
        //TODO: thumbnails and database
        return implode("; ", $images);
    }

}
