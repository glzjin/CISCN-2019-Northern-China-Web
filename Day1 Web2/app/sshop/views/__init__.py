from Shop import *
from User import *
from Admin import *


handlers = [
    (r'/', ShopIndexHandler),
    (r'/shop', ShopListHandler),
    (r'/info/(\d+)', ShopDetailHandler),
    (r'/shopcar', ShopCarHandler),
    (r'/shopcar/add', ShopCarAddHandler),
    (r'/pay', ShopPayHandler),
    (r'/user', UserInfoHandler),
    (r'/user/change', changePasswordHandler),
    (r'/pass/reset', ResetPasswordHanlder),
    (r'/login', UserLoginHanlder),
    (r'/logout', UserLogoutHandler),
    (r'/register', RegisterHandler),
    (r'/b1g_m4mber', AdminHandler)
]