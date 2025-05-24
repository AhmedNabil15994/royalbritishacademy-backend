<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate</title>
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <!--    <link rel="stylesheet" href="css/bootstrap.css">-->
  <link rel="stylesheet" href="{{ asset('frontend/certificate') }}/css/style.css">

</head>

<body>
  <div class="container pm-certificate-container">
    <div class="outer-border"></div>
    <div class="inner-border"></div>

    <div class="pm-certificate-border col-xs-12">

      <div class="row pm-certificate-header">
        <div class="pm-certificate-title  col-xs-4 text-center">
          <img src="{{ asset('frontend/certificate') }}/img/car.png" />
        </div>
        <div class="pm-certificate-title  col-xs-4 text-center">
          <img src="{{ asset('frontend/certificate') }}/img/SiteLogo.png" />
        </div>
        <div class="pm-certificate-title  col-xs-4 text-center">
          <img src="{{ asset('frontend/certificate') }}/img/Logo-right.png" />
        </div>
      </div>

      <div class="row pm-certificate-body">

        <div class="pm-certificate-block">
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-3">
                <!-- LEAVE EMPTY -->
              </div>
              <div class="pm-certificate-name margin-0-20 col-xs-6 text-center">
                <span class="pm-name-text bold">أكاديمية ناريز</span>
              </div>
              <div class="col-xs-3">
                <!-- LEAVE EMPTY -->
              </div>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-3">
                <!-- LEAVE EMPTY -->
              </div>
              <div class="pm-certificate-name underline margin-0-20 col-xs-6 text-center">
                <span class="pm-name-text-user kufi bold">{{ $orderCourse->user->name }} </span>
              </div>
              <div class="col-xs-3">
                <span class="pm-name-text-right bold">تشهد بأن</span>
              </div>
            </div>
          </div>


          <div class="col-xs-12">
            <div class="row">
              <div class="col-xs-3">
                <!-- LEAVE EMPTY -->
              </div>
              <div class="pm-course-title underline col-xs-6 text-center">
                <span class="pm-credits-text block bold kufi">{{ $orderCourse->course->title }}</span>
              </div>
              <div class="col-xs-3">
                <span class="pm-name-text-right bold">قد تم إجتيازكم دورة</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="row">
            <div class="pm-certificate-footer">
              <div class="col-xs-4 pm-certified col-xs-4 text-center">
                <span class="pm-credits-text block sans">المدرب</span>
                <span class="pm-empty-space block underline"></span>
                <span class="bold block kufi">{{ $orderCourse->course->trainer->name }}</span>
                <span class="block mt-5"><img src="{{ asset('frontend/certificate') }}/img/tawqeea.png" /></span>
              </div>
              <div class="col-xs-4">
                <!-- LEAVE EMPTY -->
              </div>

              <div class="col-xs-4 pm-certified col-xs-4 text-center">
                <span class="pm-credits-text block sans">التاريخ</span>
                <span class="pm-empty-space block underline"></span>
                <span class="bold block">{{ date('Y-m-d') }}</span>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
</body>

</html>
