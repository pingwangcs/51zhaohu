<?php
elgg_make_sticky_form('usecoupon');
useQrCouponImpl();
elgg_clear_sticky_form('usecoupon');
forward(REFERER);
