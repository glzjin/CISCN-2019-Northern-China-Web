import tornado.web
from sqlalchemy.orm.exc import NoResultFound
from sshop.base import BaseHandler
from sshop.models import Commodity, User, Raise
from sshop.settings import limit,Discount,Discount_money


class ShopIndexHandler(BaseHandler):
    def get(self, *args, **kwargs):
        return self.redirect('/shop')


class ShopListHandler(BaseHandler):
    def get(self):
        page = self.get_argument('page', 1)
        page = int(page) if int(page) else 1
        commoditys = self.orm.query(Commodity) \
            .filter(Commodity.amount > 0) \
            .limit(limit).offset((page - 1) * limit).all()
        raises = self.orm.query(Raise).filter(Raise.id == 1).first()
        return self.render('index.html', commoditys=commoditys, raises=raises.money, preview=page - 1, next=page + 1,
                           limit=limit)


class ShopDetailHandler(BaseHandler):
    def get(self, id=1):
        try:
            commodity = self.orm.query(Commodity) \
                .filter(Commodity.id == int(id)).one()
        except NoResultFound:
            return self.redirect('/')
        return self.render('info.html', commodity=commodity)


class ShopPayHandler(BaseHandler):
    @tornado.web.authenticated
    def post(self):
        try:
            try:
                id = self.get_argument('id')
            except:
                id = 1
            user = self.orm.query(User).filter(User.username == self.current_user).one()
            commodity = self.orm.query(Commodity).filter(Commodity.id == id).one()
            if commodity.amount <= 0 or user.integral < float(commodity.price):
                self.orm.commit()
                return self.render('pay.html', danger=1)
            else:
                commodity.amount -= 1
                user.integral = user.pay(float(commodity.price))
                raises = self.orm.query(Raise).filter(Raise.id == 1).one()
                raises.money = raises.add(float(commodity.price))
                self.orm.commit()
                return self.render('pay.html', success=1)
        except:
            return self.render('pay.html', danger=1)


class ShopCarHandler(BaseHandler):
    @tornado.web.authenticated
    def get(self, *args, **kwargs):
        id = self.get_secure_cookie('commodity_id')
        if id and int(id):
            commodity = self.orm.query(Commodity).filter(Commodity.id == id).one()
            raises = self.orm.query(Raise).filter(Raise.id == 1).first()
            self.orm.commit()
            if raises.money > Discount_money:
                discount = Discount
                return self.render('shopcar.html', commodity=commodity, discount=discount)
            return self.render('shopcar.html', commodity=commodity, discount=0)
        return self.render('shopcar.html')

    @tornado.web.authenticated
    def post(self, *args, **kwargs):
        try:
            try:
                id = self.get_argument('id')
            except:
                id = 1
            try:
                discount = float(self.get_argument('discount'))
            except:
                discount=1
            commodity = self.orm.query(Commodity).filter(Commodity.id == id).one()
            user = self.orm.query(User).filter(User.username == self.current_user).one()
            if commodity.amount <= 0 or discount <= 0 or discount >1 or user.integral < float(commodity.price)*discount:
                self.orm.commit()
                self.clear_cookie('commodity_id')
                return self.render('shopcar.html', danger=1)
            else:
                commodity.amount -= 1
                pay=float(commodity.price)*discount
                user.integral = user.pay(pay)
                raises = self.orm.query(Raise).filter(Raise.id == 1).one()
                raises.money = raises.add(float(commodity.price))
                self.orm.commit()
                if commodity.name == 'b*sh*':
                    return  self.redirect('/b1g_m4mber')
                return self.render('shopcar.html', success=1)
        except Exception as ex:
            print str(ex)
        return self.redirect('/shopcar')


class ShopCarAddHandler(BaseHandler):
    def post(self, *args, **kwargs):
        id = self.get_argument('id')
        self.set_secure_cookie('commodity_id', id)
        return self.redirect('/shopcar')
