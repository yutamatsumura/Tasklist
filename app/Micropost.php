<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function favorited()
    {
        return $this->belongsToMany(User::class, 'favorite', 'post_id', 'user_id')->withTimestamps();
    }
    
    public function unfavorited($postId)
    {
        // お気に入りされているかの確認
        // 1人以上にお気に入りされて入れば解除する
        $count_favorited = $this->favorited()->count();
        
        if ($count_favorited > 0) {
            // 既にお気に入りしていればお気に入りを外す
            $this->favorited()->detach();
            return true;
        } else {
            // 未お気に入りであれば何もしない
            return false;
        }
    }

}