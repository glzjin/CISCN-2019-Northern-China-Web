import os
import views
import tornado.web
from settings import debug, cookie_secret


class Application(tornado.web.Application):
    def __init__(self):
        self.root_path = os.path.dirname(__file__)
        handlers = views.handlers
        settings = dict(
            static_path=os.path.join(self.root_path, 'template/assets'),
            template_path=os.path.join(self.root_path, 'template'),
            login_url='/login',
            cookie_secret=cookie_secret,
            debug=debug,
            xsrf_cookies=True
        )
        super(Application, self).__init__(handlers, **settings)


