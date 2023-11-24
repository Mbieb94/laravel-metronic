@extends('skeleton')

@section('content')    
    <div id="kt_app_content_container" class="app-container container-xxl kt_app_content_dashboard">
        {{-- <div class="row w-100 gy-10 mb-md-20">
            <p class="speech-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit iste expedita tempore perspiciatis laudantium, alias inventore harum cupiditate consequuntur sapiente ratione eos, perferendis modi consequatur assumenda exercitationem temporibus sint nam?</p>
            <p class="speech-text">Anak kost adalah sebutan untuk mereka yang tinggal di asrama atau kos-kosan. Dalam lingkungan anak kost, kebersamaan dan kemandirian menjadi bagian penting. Mereka berasal dari berbagai daerah, menciptakan keanekaragaman budaya. Di sini, mereka belajar hidup mandiri, mengatur waktu, dan berbagi cerita. Perkembangan karakter dan bertemu teman sebaya adalah manfaat besar. Anak kost juga belajar saling menghormati, menghadapi perbedaan, dan menumbuhkan rasa solidaritas. Pengalaman berharga ini menciptakan kenangan indah sepanjang hidup. Kehangatan dan keseruan menjadi daya tarik, menjadikan anak kost sebagai fase berharga dalam perjalanan menuju kedewasaan.</p>
        </div> --}}
        {{-- <section id="auth-button"></section>
        <section id="view-selector"></section>
        <section id="timeline"></section> --}}
    </div>
@endsection

@section('customjs')

<script>
  $(function() {
    
    // document.getElementById("sample").addEventListener("click", function() {
    //   // Replace these values with your actual API URL, username, and password
    //   const apiUrl = "https://esign-dev.layanan.go.id/api/v2/seal/get/activation";
    //   const username = "esign";
    //   const password = "wrjcgX6526A2dCYSAV6u";

    //   // Construct the Basic Authentication header
    //   const headers = new Headers({
    //       "Authorization": "Basic " + btoa(username + ":" + password),
    //       "Content-Type": "application/json",
    //       "Content-Length": "<calculated when request is sent>",
    //       "Host": "<calculated when request is sent>",
    //       // 'User-Agent ' : 'PostmanRuntime/7.32.3',
    //       "Access-Control-Allow-Origin" : "*",
    //       "Accept": "*/*",
    //       "Accept-Encoding": "gzip, deflate, br",
    //       "Connection": "keep-alive",
    //   });

    //   // Create the request options
    //   const requestOptions = {
    //       method: "POST", // Replace with "POST" if needed
    //       headers: headers
    //   };

    //   // Make the AJAX request using Fetch API
    //   fetch(apiUrl, requestOptions)
    //     .then(response => {
    //         if (!response.ok) {
    //             throw new Error(`Request failed with status: ${response.status}`);
    //         }
    //         return response.json();
    //     })
    //     .then(data => {
    //         // Handle the response data here
    //         document.getElementById("responseContainer").innerHTML = JSON.stringify(data, null, 2);
    //     })
    //     .catch(error => {
    //         console.error(error);
    //         document.getElementById("responseContainer").innerHTML = "Error occurred.";
    //     });
    // });
  });
</script>

{{-- <script>
    (function(d){
       var s = d.createElement("script");
       /* uncomment the following line to override default position*/
       /* s.setAttribute("data-position", 1);*/
       /* uncomment the following line to override default size (values: small, large)*/
       /* s.setAttribute("data-size", "large");*/
       /* uncomment the following line to override default language (e.g., fr, de, es, he, nl, etc.)*/
       /* s.setAttribute("data-language", "null");*/
       /* uncomment the following line to override color set via widget (e.g., #053f67)*/
       /* s.setAttribute("data-color", "#2d68ff");*/
       /* uncomment the following line to override type set via widget (1=person, 2=chair, 3=eye, 4=text)*/
       /* s.setAttribute("data-type", "1");*/
       /* s.setAttribute("data-statement_text:", "Our Accessibility Statement");*/
       /* s.setAttribute("data-statement_url", "http://www.example.com/accessibility";*/
       /* uncomment the following line to override support on mobile devices*/
       /* s.setAttribute("data-mobile", true);*/
       /* uncomment the following line to set custom trigger action for accessibility menu*/
       /* s.setAttribute("data-trigger", "triggerId")*/
       s.setAttribute("data-account", "1IUZrMWFRn");
       s.setAttribute("src", "https://cdn.userway.org/widget.js");
       (d.body || d.head).appendChild(s);})(document)
</script>
<noscript>
Please ensure Javascript is enabled for purposes of 
<a href="https://userway.org">website accessibility</a>
</noscript> --}}

{{-- <script>
    (function(w,d,s,g,js,fjs){
      g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(cb){this.q.push(cb)}};
      js=d.createElement(s);fjs=d.getElementsByTagName(s)[0];
      js.src='https://apis.google.com/js/platform.js';
      fjs.parentNode.insertBefore(js,fjs);js.onload=function(){g.load('analytics')};
    }(window,document,'script'));
</script>
<script>
    gapi.analytics.ready(function() {
    
      // Step 3: Authorize the user.
    
      var CLIENT_ID = 347513544;
    
      gapi.analytics.auth.authorize({
        container: 'auth-button',
        clientid: CLIENT_ID,
      });
    
      // Step 4: Create the view selector.
    
      var viewSelector = new gapi.analytics.ViewSelector({
        container: 'view-selector'
      });
    
      // Step 5: Create the timeline chart.
    
      var timeline = new gapi.analytics.googleCharts.DataChart({
        reportType: 'ga',
        query: {
          'dimensions': 'ga:date',
          'metrics': 'ga:sessions',
          'start-date': '30daysAgo',
          'end-date': 'yesterday',
        },
        chart: {
          type: 'LINE',
          container: 'timeline'
        }
      });
    
      // Step 6: Hook up the components to work together.
    
      gapi.analytics.auth.on('success', function(response) {
        viewSelector.execute();
      });
    
      viewSelector.on('change', function(ids) {
        var newIds = {
          query: {
            ids: ids
          }
        }
        timeline.set(newIds).execute();
      });
    });
</script> --}}
@endsection