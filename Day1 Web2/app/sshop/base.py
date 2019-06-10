import tornado.web
from models import db
import jwt
from sshop.settings import jwt_secret

class BaseHandler(tornado.web.RequestHandler):
    @property
    def orm(self):
        return db()

    def on_finish(self):
        db.remove()

    def get_current_user(self):
        if not self.get_cookie("JWT") :
            return self.get_cookie("JWT")
        else :
            name=jwt.decode(self.get_cookie("JWT").encode('utf-8'), jwt_secret, algorithms=['HS256'])
            return name['username']

