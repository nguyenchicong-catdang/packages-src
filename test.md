# xu ly intelephense
> "ln -s [Nguồn_Thật] [Tên_Link_Mới]".

> giống như lệnh copy (cp): cp [Nguồn] [Đích].

> ln -s /home/cong/git/packages-app/laravel-app/vendor /home/cong/git/packages-src/vendor

> ls -l /home/cong/git/packages-src/vendor

/home/cong/git/packages-src/vendor -> /home/cong/git/packages-app/laravel-app/vendor

> unlink /home/cong/git/packages-src/vendor

> unlink dích

# test xử lý link packages

/home/cong/git/packages-src

/home/cong/git/packages-app/laravel-app

ln -s /home/cong/git/packages-src /home/cong/git/packages-app/laravel-app/packages-src

unlink /home/cong/git/packages-app/laravel-app/packages-src

# test link app
ln -s /home/cong/git/packages-app/laravel-app /home/cong/git/packages-src/laravel-app