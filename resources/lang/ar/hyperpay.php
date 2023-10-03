<?php

return [
    '100.100.100' => 'لا يحتوي الطلب على بطاقة ائتمان أو رقم حساب مصرفي أو اسم مصرف',
    '100.100.101' => 'بطاقة ائتمان أو رقم حساب مصرفي أو اسم مصرف غير صالح',
    '100.100.104' => 'معرف فريد / معرف فريد جذري غير صالح',
    '100.100.200' => 'الطلب لا يحتوي على شهر',
    '100.100.201' => 'شهر غير صالح',
    '100.100.300' => 'الطلب لا يحتوي على سنة',
    '100.100.301' => 'سنة غير صالحة',
    '100.100.303' => 'البطاقة منتهية الصلاحية',
    '100.100.304' => 'البطاقة ليست صالحة بعد',
    '100.100.305' => 'تنسيق تاريخ انتهاء الصلاحية غير صالح',
    '100.100.400' => 'الطلب لا يحتوي على صاحب ائتمان نقدي/ حساب مصرفي',
    '100.100.401' => 'رقم الحساب المصرفي قصير جدًا أو طويل جدًا',
    '100.100.402' => 'صاحب الحساب المصرفي غير صالح',
    '100.100.500' => 'نوع البطاقة غير صالح',
    '100.100.501' => 'نوع البطاقة غير صالح',
    '100.100.600' => 'غير مسموح برمز CVV فارغ لفيزا ماستر اميكس ',
    '100.100.601' => 'نوع البطاقة غير صالح',
    '100.100.650' => 'غير مسموح برقم إصدار بطاقة الائتمان الفارغ للمايسترو',
    '100.100.651' => 'رقم إصدار بطاقة الائتمان غير صالح',
    '100.100.700' => 'نوع البطاقة غير صالح',
    '100.100.701' => 'للاشتباه في الاحتيال ، قد لا تتم معالجة هذه البطاقة',
    '100.200.100' => 'يحتوي الحساب المصرفي على تركيبة رمز المصرف واسم  حساب ذات اسم رمز مصرفي غير صالح',
    '100.200.104' => 'الحساب المصرفي له تنسيق رقم حساب غير صالح',
    '100.200.200' => 'يجب تسجيل الحساب المصرفي وتأكيده أولاً. البلد قائم على نظام التفويضً.',
    '100.210.101' => 'لا يحتوي الحساب الافتراضي على معرّف أو معرف غير صالح',
    '100.210.102' => 'لا يحتوي الحساب الافتراضي على أي بطاقة أو نوع بطاقة غير صالح',
    '100.211.101' => 'حساب المستخدم لا يحتوي على مُعرف أو يحتوي على مُعرف غير صالح',
    '100.211.102' => 'حساب المستخدم لا يحتوي على نوع عربة الشراء أو على نوع غير صالح',
    '100.211.103' => 'لم يتم تحديد كلمة السر لحساب المستخدم',
    '100.211.104' => 'كلمة السر لا تفي بمتطلبات السلامة (يجب أن تتكون من 8 أرقام وحروف على الأقل ويجب أن تحتوي على حروف وأرقام)',
    '100.211.105' => 'يجب أن يكون مُعرف المحفظة عنوان بريد إلكتروني صحيحًا',
    '100.211.106' => 'تحتوي معرفات القسائم دائمًا على 32 رقمًا',
    '100.212.101' => 'يجب ألا يحتوي تسجيل حساب المحفظة على رصيد ابتدائي',
    '100.212.102' => 'لا يحتوي حساب المحفظة على بطاقة أو أن نوع البطاقة غير صالح',
    '100.212.103' => 'تحتاج معاملة الدفع لحساب المحفظة إلى مرجع إلى التسجيل',
    '100.550.300' => 'لا يحتوي الطلب على أي مبلغ  أو مبلغ قليل جدًا',
    '100.550.301' => 'المبلغ كبير جدا',
    '100.550.303' => 'تنسيق المبلغ غير صالح (يسمح فقط برقمين عشريين).',
    '100.550.310' => 'يتجاوز المبلغ حد الحساب المسجل.',
    '100.550.311' => 'تجاوز رصيد الحساب',
    '100.550.312' => 'المبلغ خارج حدود حجم التذكرة المسموح بها',
    '100.550.400' => 'لا يحتوي الطلب على عملة',
    '100.550.401' => 'عملة غير صالحة',
    '100.550.601' => 'مقدار المخاطرة كبير جدًا',
    '100.550.603' => 'تنسيق مبلغ المخاطرة غير صالح (يُسمح فقط برقمين عشريين)',
    '100.550.605' => 'مبلغ المخاطرة أصغر من المبلغ (يجب أن يكون مساويًا أو أكبر منه)',
    '100.550.701' => 'المبالغ غير المتطابقة',
    '100.550.702' => 'العملات غير متطابقة',
    '100.380.101' => 'المعاملة لا تحتوي على جزء إدارة المخاطر',
    '100.380.201' => 'لم يتم تحديد نوع عملية إدارة المخاطر',
    '100.380.305' => 'لم يتم تقديم معلومات عن الواجهة الأمامية للمعاملات غير المتزامنة',
    '100.380.306' => 'لم يتم تقديم بيانات المصادقة في معاملة إدارة المخاطر',
    '000.100.200' => 'السبب غير محدد',
    '000.100.201' => 'تفاصيل الحساب أو المصرف غير صحيحة',
    '000.100.202' => 'الحساب مغلق',
    '000.100.203' => 'رصيد غير كاف',
    '000.100.204' => 'التفويض غير صالح',
    '000.100.205' => 'التفويض ملغى',
    '000.100.206' => 'الفسخ أو النزاع',
    '000.100.207' => 'الإلغاء في شبكة المقاصة',
    '000.100.208' => 'حساب تم حظره',
    '000.100.209' => 'الحساب غير موجود',
    '000.100.210' => 'مبلغ غير صحيح',
    '000.100.211' => 'نجحت المعاملة (مبلغ المعاملة أقل من مبلغ التفويض المسبق)',
    '000.100.212' => 'نجحت المعاملة (مبلغ المعاملة أكبر من مبلغ التفويض المسبق)',
    '000.100.220' => 'معاملة احتيالية',
    '000.100.221' => 'لم يتم استلام البضائع',
    '000.100.222' => 'المعاملة غير معترف بها من قبل حامل البطاقة',
    '000.100.223' => 'لم يتم تقديم الخدمة',
    '000.100.224' => 'معالجة مكررة',
    '000.100.225' => 'لم تتم معالجة الائتمان',
    '000.100.226' => 'لا يمكن تسويتها',
    '000.100.227' => 'مشكلة بالتهيئة',
    '000.100.228' => 'خطأ اتصال مؤقت - أعد المحاولة',
    '000.100.229' => 'تعليمات غير صحيحة',
    '000.100.230' => 'رسوم غير مصرح بها',
    '000.100.231' => 'إقرار متأخر',
    '000.100.232' => 'تحويل المسؤولية',
    '000.100.233' => 'رد المبالغ المدفوعة المتعلقة بالتفويض',
    '000.100.234' => 'عدم استلام البضائع',
    '000.100.299' => 'غير محدد (تقني)',
    '500.100.201' => 'القناة / التاجر غير مفعّل (لا معالجة ممكنة)',
    '500.100.202' => 'القناة / التاجر جديد (لا معالجة ممكنة)',
    '500.100.203' => 'القناة / التاجر مغلق (لا يمكن إجراء معالجة)',
    '500.100.301' => 'تم تعطيل موصل التاجر- (لا يمكن إجراء معالجة)',
    '500.100.302' => 'موصل التاجر جديد (لا يمكن المعالجة حتى الآن)',
    '500.100.303' => 'موصل التاجر مغلق (لا يمكن إجراء معالجة)',
    '500.100.304' => 'تم تعطيل موصل التاجر عند البوابة (لا يمكن إجراء معالجة)',
    '500.100.401' => 'الموصل غير متاح (لا يمكن المعالجة)',
    '500.100.402' => 'الموصل جديد (لا يمكن المعالجة حتى الآن)',
    '500.100.403' => 'الموصل غير متاح (لا يمكن المعالجة)',
    '500.200.101' => 'لم يتم ضبط حساب مستهدف لمعاملة دفع عن الطلب',
    '600.200.100' => 'طريقة الدفع غير صالحة',
    '600.200.200' => 'طريقة دفع غير مدعومة',
    '600.200.201' => 'القناة / التاجر غير مهيأ لطريقة الدفع هذه',
    '600.200.202' => 'القناة / التاجر غير مهيأ لنوع الدفع هذا',
    '600.200.300' => 'نوع الدفع غير صالح',
    '600.200.310' => 'نوع الدفع غير صالح لطريقة الدفع المحددة',
    '600.200.400' => 'نوع الدفع غير المدعوم',
    '600.200.500' => 'بيانات الدفع غير صالحة. أنت غير مهيأ لهذه العملة أو النوع الفرعي (الدولة أو العلامة التجارية)',
    '600.200.501' => 'بيانات الدفع غير صالحة للمعاملة المتكررة. بيانات التاجر أو المعاملة بها تهيئة متكررة خاط',
    '600.200.600' => 'رمز دفع غير صالح (النوع أو الطريقة)',
    '600.200.700' => 'وضع الدفع غير صالح (أنت غير مهيأ لوضع المعاملة المطلوب)',
    '600.200.800' => 'علامة تجارية غير صالحة لطريقة الدفع ووضع الدفع المحدد (أنت غير مهيأ لوضع المعاملة المطلوب)',
    '600.200.810' => 'تم توفير رمز إرجاع غير صالح',
    '600.300.101' => 'مفتاح التاجر غير موجود',
    '600.300.200' => 'عنوان IP لمصدر التاجر غير مدرج في القائمة البيضاء',
    '600.300.210' => 'إشعار رابط عنوان URL للتاجر ليس مدرجًا في القائمة البيضاء',
    '600.300.211' => 'رابط عنوان URL للمتسوق غير مدرج في القائمة البيضاء',
    '800.121.100' => 'القناة غير مهيئة لنوع المصدر المحدد. يرجى الاتصال بمدير حسابك.',
    '800.121.200' => 'لم يتم تمكين الاستعلام الآمن لهذا الكيان. يرجى الاتصال بمدير حسابك.',
    '100.150.100' => 'الطلب لا يحتوي على بيانات الحساب ولا معرّف التسجيل',
    '100.150.101' => 'تنسيق غير صالح لمعرف التسجيل المحدد (يجب أن يكون بتنسيق معرف الفريد العالمي)',
    '100.150.200' => 'التسجيل غير موجود',
    '100.150.201' => 'لم يتم تأكيد التسجيل بعد',
    '100.150.202' => 'تم إلغاء التسجيل بالفعل',
    '100.150.203' => 'التسجيل غير صالح ، وربما تم رفضه في البداية',
    '100.150.204' => 'لم يشر مرجع تسجيل الحساب إلى أي معاملة التسجيل',
    '100.150.205' => 'التسجيل المشار إليه لا يحتوي على حساب',
    '100.150.300' => 'الدفع مسموح به فقط مع تسجيل مبدئي سليم',
    '100.350.100' => 'تم رفض الجلسة المشار إليها (لا يوجد إجراء ممكن).',
    '100.350.101' => 'الجلسة المشار إليها مغلقة (لا يوجد إجراء ممكن)',
    '100.350.200' => 'حالة جلسة غير محددة',
    '100.350.201' => 'الإشارة إلى تسجيل من خلال مُعرف المرجع غير قابل للتطبيق على نوع الدفع هذا',
    '100.350.301' => 'يجب تسجيل  (RG) التأكيد (CF) أولاً',
    '100.350.302' => 'تم تأكيد(CF) الجلسة بالفعل ',
    '100.350.303' => 'لا يمكن إلغاء تسجيل (DR) حسابًا  و / أو العميل غير مسجل',
    '100.350.310' => 'لا يمكن تأكيد (CF) جلسة  عبر لغة الترميز الممتدة (XML)',
    '100.350.311' => 'لا يمكن تأكيد (CF) على قناة عبور التسجيل',
    '100.350.312' => 'لا يمكن القيام بالمرور على موصل غير داخلي',
    '100.350.313' => 'التسجيل من هذا النوع يجب أن يقدم عنوان url للتأكيد',
    '100.350.314' => 'لا يمكن إخطار العميل برقم التعريف الشخصي(PIN) لتأكيد التسجيل (قناة)',
    '100.350.315' => 'لا يمكن إخطار العميل برقم التعريف الشخصي(PIN) لتأكيد التسجيل (فشل الارسال)',
    '100.350.400' => 'لم يتم إدخال رقم التعريف الشخصي PIN  أو كان غير صالح (مصادقة البريد الإلكتروني / رسائل نصية قصيرة / إيداع تجريبي) ',
    '100.350.500' => 'غير قادر على الحصول على حساب شخصي (افتراضي) - على الأرجحلا مزيد من الحسابات المتاحة',
    '100.350.601' => 'غير مسموح بالتسجيل للإشارة إلى معاملة أخرى',
    '100.350.602' => 'لا يُسمح بالتسجيل لترحيل الدفع المتكرر',
    '100.250.100' => 'المهمة لا تحتوي على معلومات التنفيذ',
    '100.250.105' => 'نوع الإجراء غير صالح أو مفقود',
    '100.250.106' => 'وحدة المدة غير صالحة أو مفقودة',
    '100.250.107' => 'وحدة إشعار غير صالحة أو مفقودة',
    '100.250.110' => 'تنفيذ المهمة المفقودة',
    '100.250.111' => 'تعبير وظيفي مفقود',
    '100.250.120' => 'مجموعة معلمات التنفيذ غير صالحة، لا يتوافق مع المعيار',
    '100.250.121' => 'معلمات تنفيذ غير صالحة ، يجب أن تكون الساعة بين 0 و 23',
    '100.250.122' => 'معلمات التنفيذ غير صالحة ، يجب أن تكون الدقائق والثواني بين 0 و 59',
    '100.250.123' => 'معلمات تنفيذ غير صالحة ، يجب أن يكون يوم من الشهر بين 1 و 31',
    '100.250.124' => 'معلمات التنفيذ غير صالحة ، يجب أن يكون الشهر  بين 1 و 12',
    '100.250.125' => 'معلمات تنفيذ غير صالحة ، يجب أن يكون يوم من الأسبوع بين 1 و 7',
    '100.250.250' => 'علامة الوظيفة مفقودة',
    '100.360.201' => 'نوع جدول غير معروف',
    '100.360.300' => 'لا يمكن جدولة (SD) وظيفة غير مجدولة',
    '100.360.303' => 'لا يمكن إلغاء جدولة مهمة (DS) غير المجدولة',
    '100.360.400' => 'وحدة الجدول الزمني غير مهيأة لوضع المعاملة المباشرة',
    '700.100.100' => 'معرف المرجع غير موجود',
    '700.100.200' => 'المبلغ المرجعي غير المطابق',
    '700.100.300' => 'كمية غير صالحة (ربما كبيرة جدا)',
    '700.100.400' => 'طريقة الدفع المشار إليها لا تتطابق مع طريقة الدفع المطلوبة',
    '700.100.500' => 'عملة الدفع المشار إليها لا تتطابق مع عملة الدفع المطلوبة',
    '700.100.600' => 'الوضع المشار إليه لا يتطابق مع وضع الدفع المطلوب',
    '700.100.700' => 'المعاملة المشار إليها من النوع غير المناسب',
    '700.100.701' => 'أشار إلى معاملة قاعدة البيانات بدون تقديم حساب صراحةً. غير مسموح باستخدام الحساب المشار إليه.',
    '700.100.710' => 'ربط تقاطعي بين شجرتين للمعاملات',
    '700.300.100' => 'لا يمكن استرداد tx المشار إليه أو التقاطه أو عكسه (نوع غير صحيح)',
    '700.300.200' => 'تم رفض TX المشار إليه',
    '700.300.300' => 'لا يمكن استرداد tx المشار إليه أو التقاطه أو عكسه (تم استرداها بالفعل أو الاستيلاء عليها أو عكسها)',
    '700.300.400' => 'لا يمكن التقاط tx المشار إليه (تم الوصول إلى وقت التوقف)',
    '700.300.500' => 'خطأ في رد المبالغ المدفوعة (عمليات متعددة لرد المبالغ المدفوعة)',
    '700.300.600' => 'لا يمكن استرداد أو عكس tx المشار إليه (تم رد المبالغ المدفوعة)',
    '700.300.700' => 'لا يمكن عكس tx المشار إليه(الانعكاس غير ممكن بعد الآن)',
    '700.300.800' => 'لا يمكن إبطال tx المشار إليه',
    '700.400.000' => 'خطأ جسيم في سير العمل (الاتصال بالدعم)',
    '700.400.100' => 'لا يمكن الالتقاط (تم تجاوز قيمة التفويض المسبق ، تم إرجاع التفويض المسبق أو سير عمل غير صالح؟)',
    '700.400.101' => 'لا يمكن الالتقاط (غير مدعوم من قبل نظام التفويض)',
    '700.400.200' => 'لا يمكن الاسترداد (تم تجاوز حجم الاسترداد أو تم عكس النص أو سير عمل غير صالح؟)',
    '700.400.300' => 'لا يمكن العكس (تم رده بالفعل | أو عكسه، أو سير عمل غير صالح أو تجاوز المبلغ)',
    '700.400.400' => 'لا يمكن رد المبالغ المدفوعة (تم ردها بالفعل أو سير العمل غير صالح؟)',
    '700.400.402' => 'يمكن إنشاء رد المبالغ المدفوعة داخليًا فقط بواسطة نظام الدفع',
    '700.400.410' => 'لا يمكن عكس عملية رد المبالغ المدفوعة (تم بالفعل عكس رد المبالغ المدفوعة أو أن سير العمل غير صالح؟)',
    '700.400.411' => 'لا يمكن عكس رد المبالغ المدفوعة أو سير العمل غير صالح (رد المبالغ المدفوعة الثاني)',
    '700.400.420' => 'لا يمكن عكس عملية رد المبالغ المدفوعة (لا يوجد رد مبالغ مدفوعة أو سير عمل غير صالح؟)',
    '700.400.510' => 'الالتقاط يحتاج معاملة ناجحة واحدة على الأقل من النوع التفويض المسبق',
    '700.400.520' => 'يحتاج رد الأموال إلى معاملة ناجحة واحدة على الأقل من النوع (الالتقاطCP أو DBقاعدة البيانات أو RB إعادة الإصدار أو دفعة متكررةRC)',
    '700.400.530' => 'يحتاج الانعكاس إلى معاملة ناجحة واحدة على الأقل من النوع (الالتقاطCP أو DBقاعدة البيانات أو RB إعادة الإصدار أو دفعة متكررةRC)',
    '700.400.540' => 'إعادة تصور يحتاج معاملة ناجحة واحدة على الأقل من النوع (الالتقاطCP أو DBقاعدة البيانات أو RB إعادة الإصدار )',
    '700.400.550' => 'يحتاج رد المبالغ المدفوعة إلى معاملة ناجحة واحدة على الأقل من النوع (الالتقاطCP أو DBقاعدة البيانات أو RB إعادة الإصدار )',
    '700.400.560' => 'يحتاج الإيصال إلى معاملة ناجحة واحدة على الأقل من النوع (الالتقاطCP أو DBقاعدة البيانات أو RB إعادة الإصدار أو دفعة متكررةRC)',
    '700.400.561' => 'يحتاج إيصال التسجيل إلى تسجيل ناجح في الحالة مفتوح',
    '700.400.562' => 'يتم تهيئة الإيصالات ليتم إنشاؤها داخليًا فقط بواسطة نظام الدفع',
    '700.400.565' => 'عملية الإنهاء تحتاج إلى معاملة ناجحة واحدة على الأقل من النوع(PA التفويض المسبق أو DB قاعدة البيانات)',
    '700.400.570' => 'لا يمكن الإشارة إلى معاملة قيد الانتظار / معلق',
    '700.400.580' => 'لا يمكن العثور على المعاملات',
    '700.400.590' => 'يحتاج التقسيط إلى معاملة ناجحة واحدة على الأقل من النوع(DB أو PA)',
    '700.400.600' => 'عملية الإنهاء تحتاج إلى معاملة ناجحة واحدة على الأقل من النوع (IN أو  قاعدة بياناتDB أو Paتفويض مسبق أو CD)',
    '700.400.700' => 'معرّفات القناة الأولية والمرجعية غير متطابقة',
    '700.450.001' => 'لا يمكن تحويل الأموال من حساب واحد إلى نفس الحساب',
    '700.500.001' => 'تحتوي الجلسة المشار إليها على عدد كبير جدًا من المعاملات',
    '700.500.002' => 'يظهر الالتقاط أو التفويض المسبق متأخرًا جدًاالجلسة المشار إليها',
    '700.500.003' => 'حسابات الاختبار غير مسموح بها في الإنتاج',
    '700.500.004' => 'لا يمكن إحالة معاملة تحتوي على حذفمعلومات العميل',
    '100.300.101' => 'وضع الاختبار غير صالح (يرجى استخدام LIVE أو INTEGRATOR_TESTأو CONNECTOR_TEST)',
    '100.300.200' => 'معرّف المعاملة طويل جدًا',
    '100.300.300' => 'معرف مرجعي غير صالح',
    '100.300.400' => 'معرف قناة مفقود أو غير صالح',
    '100.300.401' => 'معرف المرسل مفقود أو غير صالح',
    '100.300.402' => 'نسخة مفقودة أو غير صالحة',
    '100.300.501' => 'معرف استجابة غير صالح',
    '100.300.600' => 'تسجيل دخول مستخدم غير صالح أو مفقود',
    '100.300.601' => 'كلمة سر مستخدم غير صالحة أو مفقودة    ',
    '100.300.700' => 'صلة غير صالحة',
    '100.300.701' => 'صلة غير صالحة لنوع الدفع المحدد',
    '100.370.100' => 'تم رفض الصفقة',
    '100.370.101' => 'لم يتم تعيين عنوان URL للاستجابة في المعاملات / الواجهة الأمامية    ',
    '100.370.102' => 'استجابة غير صحيحة Url في المعاملات / الواجهة الأمامية',
    '100.370.110' => 'يجب تنفيذ المعاملة على العنوان الألماني',
    '100.370.111' => 'خطأ في النظام (من المحتمل أن تكون بيانات الإدخال غير صحيحة / مفقودة)',
    '100.370.121' => ' نوع مؤشر التجارة الالكترونية المحدد في المصادقة غير معروف أو غير موجود',
    '100.370.122' => 'معلمة بمفتاح فارغ مقدم في مصادقة 3DSecure',
    '100.370.123' => 'لا يوجد أو نوع تحقق غير معروف محدد في مصادقة ثري دي سكيور',
    '100.370.124' => 'مفتاح معلمة غير معروف في مصادقة ثري دي سكيور',
    '100.370.125' => 'مُعرف تحقيق ثري دي سيكيور غير صحيح. يجب أن يتضمن ترميز الأساس 64 طول 28 رقم',
    '100.370.131' => 'نوع مصادقة غير معروف أو غير موجود المحدد في نوع المعاملة / المصادقة',
    '100.370.132' => 'لم يتم تحديد مؤشر نتيجة المعاملة / المصادقة / مؤشر النتيجة',
    '100.500.101' => 'طريقة الدفع غير صالحة',
    '100.500.201' => 'نوع الدفع غير صالح',
    '100.500.301' => 'تاريخ الاستحقاق غير صالح',
    '100.500.302' => 'تاريخ تفويض توقيع غير صالح',
    '100.500.303' => 'معرف تفويض غير صالح',
    '100.500.304' => 'معرف خارجي تفويض غير صالح',
    '100.600.500' => 'حقل الاستخدام طويل جدًا',
    '100.900.500' => 'وضع التكرار غير صالح',
    '200.100.101' => 'رسالة طلب غير صالحة. لا يوجد XML صالح. يجب أن يكون  XML مرموزًا بترميز URL. ربما يحتوي على علامة ضم غير مشفرة أو شيء مشابه.',
    '200.100.102' => "طلب غير صالح. تحميل XML مفقود (يجب إرسال سلسلة XML ضمن المعلمة 'تحميل')",
    '200.100.103' => 'رسالة طلب غير صالحة. الطلب يحتوي على أخطاء هيكلية',
    '200.100.150' => 'معاملة متعددة الطلبات لم تتم معالجتها بسبب المشاكل اللاحقة',
    '200.100.151' => 'يسمح بالطلبات المتعددة بحد أقصى10 معاملات فقط',
    '200.100.199' => 'واجهة الويب / عنوان URL المستخدم غير صحيح. يرجى مراجعة الفصل 3 من مستند البداية السريعة للتكنولوجيا.',
    '200.100.201' => 'علامة طلب / معاملة غير صالحة (غير موجود أو فارغة [جزئيًا])',
    '200.100.300' => 'علامة طلب / معاملة / دفع غير صالحة (لم يتم تحديد رمز أو رمز غير صالح)',
    '200.100.301' => 'علامة طلب / معاملة / دفع غير صالحة (غير موجودة أو فارغة [جزئيًا])',
    '200.100.302' => 'علامة طلب / معاملة / دفع / عرض غير صالحة (غير موجودة أو فارغة [جزئيًا])',
    '200.100.401' => 'علامة طلب / معاملة / حساب غير صالحة (غير موجودة أو فارغة [جزئيًا])',
    '200.100.402' => 'علامة طلب / معاملة / حساب (ذو صلة بالعميل) غير صالحة (يجب أن تكون واحدة وجودة للحساب / للعميل / الصلة )',
    '200.100.403' => 'علامة طلب / معاملة / تحليل غير صالحة (يجب أن يكون للمعايير اسم وقيمة)',
    '200.100.404' => 'طلب / معاملة / حساب غير صالح (يجب ألا يكون موجودًا)',
    '200.100.501' => 'عميل غير صالح أو مفقود',
    '200.100.502' => 'علامة طلب / معاملة / عميل /  اسم غير صالحة (غير موجودة أو فارغة [جزئيًا])',
    '200.100.503' => 'علامة طلب / معاملة / عميل / جهة اتصال غير صالحة(غير موجود أو فارغ [جزئيًا])',
    '200.100.504' => 'علامة طلب / معاملة / عميل / عنوان غير صالحة(غير موجود أو فارغ [جزئيًا])',
    '200.100.601' => 'علامة طلب / معاملة / (ابل باي |جوجل باي) غير صالحة (غير موجودة أو فارغة [جزئيًا])',
    '200.100.602' => 'علامة طلب / معاملة غير صالحة / (ابل باي | جوجل باي) /  الرمز المميز للدفع (غير موجودة أو فارغة [جزئيًا])',
    '200.100.603' => 'علامة طلب / معاملة غير صالحة / (ابل باي | جوجل باي) / الرمز المميز للدفع (خطأ في فك التشفير)',
    '200.200.106' => 'معاملة مكررة. يرجى التحقق من أن المُعرف الفريد العالمي فريد',
    '200.300.403' => 'طريقة HTTP غير صالحة',
    '200.300.404' => 'معلمة غير صالحة أو مفقودة',
    '200.300.405' => 'كيان مكرر',
    '200.300.406' => 'الكيان غير موجود',
    '200.300.407' => 'الكيان غير محدد بما فيه الكفاية',
    '800.900.100' => 'فشل تفويض المرسل',
    '800.900.101' => 'عنوان بريد إلكتروني غير صالح (ربما بناء جملة غير صالح)',
    '800.900.200' => 'رقم الهاتف غير صحيح (يجب أن يبدأ برقم أو + ، بطول 7 أحرف على الأقل وحد أقصى 25 حرفًا)',
    '800.900.201' => 'قناة غير معروفة',
    '800.900.300' => 'معلومات المصادقة غير صالحة',
    '800.900.301' => 'فشل تفويض المستخدم ،ليس لدى المستخدم حقوق كافية لمعالجة المعاملة',
    '800.900.302' => 'فشل التفويض',
    '800.900.303' => 'لم يتم إنشاء رمز مميز',
    '800.900.399' => 'مشكلة التسجيل الآمن',
    '800.900.401' => 'رقم IP غير صالح',
    '800.900.450' => 'خطأ في تاريخ الميلاد',
    '100.800.100' => 'الطلب لا يحتوي على شارع',
    '100.800.101' => 'مجموع الشارع 1 والشارع 2 يجب ألا يتجاوز 201 حرفًا.',
    '100.800.102' => 'مجموع من الشارع 1 و الشارع 2 يجب ألا يحتوي على أرقام فقط.',
    '100.800.200' => 'الطلب لا يحتوي على الرمز البريدي',
    '100.800.201' => 'الرمز البريدي طويل جدًا',
    '100.800.202' => 'الرمز البريدي غير صالح',
    '100.800.300' => 'الطلب لا يحتوي على مدينة',
    '100.800.301' => 'المدينة طويلة جدا',
    '100.800.302' => 'مدينة غير صالحة',
    '100.800.400' => 'دولة / دولة مختلطة غير صالحة',
    '100.800.401' => 'الدولة طويلة جدا',
    '100.800.500' => 'الطلب لا يحتوي على بلد',
    '100.800.501' => 'بلد غير صحيحة',
    '100.700.100' => 'لا يجوز أن يكون اسم العائلة فارغًا',
    '100.700.101' => 'يجب أن يكون الاسم شخصي للعميل  ما بين 0 و 50',
    '100.700.200' => 'لا يجوز أن يكون customer.givenName فارغًا',
    '100.700.201' => 'يجب أن يكون الاسم شخصي للعميل  ما بين 0 و 50',
    '100.700.300' => 'تحية غير صحيحة',
    '100.700.400' => 'عنوان غير صالح',
    '100.700.500' => 'اسم الشركة طويل جدًا',
    '100.700.800' => 'الهوية لا تحتوي على  ورق  أو ورق غير صالح',
    '100.700.801' => 'الهوية لا تحتوي على قيمة تعريف أو قيمة تعريف غير صالحة',
    '100.700.802' => 'قيمة التعريف طويلة جدًا',
    '100.700.810' => 'حدد هوية واحدة على الأقل',
    '100.900.100' => 'الطلب لا يحتوي على عنوان بريد إلكتروني',
    '100.900.101' => 'عنوان بريد إلكتروني غير صالح (ربما بناء جملة غير صالح)',
    '100.900.105' => 'عنوان البريد الإلكتروني طويل جدًا (بحد أقصى 50 حرفًا)',
    '100.900.200' => 'رقم الهاتف غير صحيح (يجب أن يبدأ برقم أو + ، بطول 7 أحرف على الأقل وحد أقصى 25 حرفًا)',
    '100.900.300' => 'رقم الهاتف المحمول غير صالح (يجب أن يبدأ برقم أو + ، بطول 7 أحرف على الأقل وحد أقصى 25 حرفًا)',
    '100.900.301' => 'رقم الهاتف المحمول إلزامي',
    '100.900.400' => 'الطلب لا يحتوي على رقم IP',
    '100.900.401' => 'رقم IP غير صالح',
    '100.900.450' => 'خطأ في تاريخ الميلاد',
    '800.100.156' => 'تم رفض المعاملة (خطأ في التنسيق)'
];
