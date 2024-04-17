<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Proposal Information</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
      <style>
         body {
         font-family: "Montserrat", sans-serif;
         }
         h1,
         h2,
         h3 {
         text-transform: uppercase;
         margin: 0;
         }
         p {
         margin: 0;
         line-height: 2rem;
         }
         p.author {
         font-weight: bold;
         font-size: 1.5rem;
         line-height: 1.5rem;
         }
         p.title {
         font-weight: light;
         font-style: italic;
         font-size: 0.8rem;
         margin-top: 0.5rem;
         margin-left: 0.2rem;
         }
         div.author-tag p {
         line-height: 1rem;
         }
         h1 {
         font-weight: bold;
         font-size: 10rem;
         line-height: 10rem;
         font-stretch: expanded;
         }
         h2 {
         font-weight: light;
         font-size: 1rem;
         line-height: 1rem;
         letter-spacing: 0.2rem;
         margin: 0 1rem;
         }
         h3 {
         font-size: 3rem;
         line-height: 10rem;
         text-transform: capitalize;
         }
         h4 {
         margin-top: 1.5rem;
         }
         .bold {
         font-weight: bold;
         }
         .header p {
         font-weight: bold;
         font-size: 6rem;
         line-height: 6.25rem;
         margin-right: 1rem;
         }
         ul {
         list-style-type: none;
         padding: 0;
         margin: 0;
         }
         .page .logo {
         align-self: end;
         padding: 20px;
         text-align: right;
         margin-top: 80px;
         }
         .header {
         align-self: start;
         padding: 20px;
         margin-top: auto;
         }
         div.author-tag,
         div.total,
         section.proposal-msg .user-msg {
         margin: 3.5rem 0;
         }
         div.user-msg {
         padding: 0 2rem;
         }
         /* Product card */
         .product-list {
         list-style-type: none;
         padding: 0;
         margin: 0;
         width: 100%;
         }
         .product-card {
         background-color: #f9f9f9;
         margin-bottom: 10px;
         padding: 10px;
         border-radius: 8px;
         display: flex;
         flex-direction: column;
         width: 100%;
         }
         .product-info {
         display: flex;
         justify-content: space-between;
         width: 100%;
         }
         .product-title {
         flex-grow: 1;
         font-weight: bold;
         font-size: 1.75rem;
         }
         .product-price, .total {
         white-space: nowrap;
         text-align: right;
         font-size: 1.5rem;
         color: rgb(75, 75, 75);
         }
         
         /* Project Scope for PDF */
         .product-description h1 {
            font-weight: bold;
            margin-bottom: 1rem;
            margin-top: 1rem;
         }

         .product-description h2, 
         .product-description h3, 
         .product-description h4, 
         .product-description h5, 
         .product-description h6 {
            font-weight: bold;
            margin-bottom: 0.75rem;
         }

         .product-description h2{
            margin: 0;
         }

         .product-description h3{
            margin: 0;
         }

         .product-description p {
            font-style: italic;
            font-weight: normal;
         }

         .product-description ul, 
         .product-description ol {
            margin-bottom: 0.5rem;
            padding-left: 20px; 
         }

         .product-description li {
            line-height: 1.5em;
            margin-bottom: 0.5rem; 
         }
         
         .product-description li {
            font-weight: bold;
         }
        
         .product-description a {
            text-decoration: underline;
            color: #0000EE; 
         }

         .product-description strong, 
         .product-description b {
            font-weight: bold;
         }

         .product-description em, 
         .product-description i {
            font-style: italic;
         }

         .product-description h1{
            font-size: 1.75rem;
            line-height: 1.75rem;
            font-weight: bold;
            text-transform: none;
         }

         .product-description h2,
         .product-description h3{
            letter-spacing: 0;
            font-size: 1.5rem;
            line-height: 1.5rem;
            font-weight: bold;
            text-transform: none;
         }

         .product-description h4,
         .product-description h5,
         .product-description h6{
            font-size: 1.25rem;
            line-height: 1.25rem;
         }

         .product-description p{
            font-size: 1rem;
            line-height: 1rem;
            margin-left: 1rem;
            margin-top: 0.5rem;
            text-transform: none;
         }
  

         /* Signature Area */
         .signature {
         margin-top: 30px;
         }
         .signature-area {
         display: flex;
         justify-content: space-between;
         align-items: center;
         margin: 20px 0;
         }
         .signature-area span {
         text-transform: uppercase
         }
         .signature-block {
         border-top: 1px solid #000;
         padding-top: 8px;
         text-align: center;
         flex: 1;
         width: 250px;
         margin-bottom: 24px;
         }
         .signature-block span {
         display: block;
         font-size: 0.8em;
         }
         /* Print-specific styles */
         @media print {
         html,
         body {
         height: 100%;
         margin: 0;
         padding: 0;
         box-shadow: none;
         }
         section {
         display: flex;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         height: 100vh;
         margin: 0 auto;
         page-break-after: always;
         padding-top: 1cm;
         padding-bottom: 1cm;
         }
         .page,
         .auto-msg,
         .proposal-msg,
         .scope-list {
         width: 100%;
         }
         .logo {
         position: absolute;
         bottom: 0;
         right: 0;
         }
         }
      </style>
   </head>
   <body>
      <main>
         <div class="">
            <section class="page">
               <div class="header">
                  <p>Let's get</p>
                  <p>together,</p>
                  <p>smash your</p>
                  <p>goals &amp; drive</p>
                  <p>results.</p>
               </div>
               <div class="logo">
                  <h1>Keen</h1>
                  <h2>Creative</h2>
               </div>
            </section>
            <section class="auto-msg">
               <h3>Hello {{ $client->first_name }},</h3>
               @foreach ($users as $user) 
               <div class="user-msg">
                  <p>{!! $user->automated_message !!}</p>
               </div>
               @endforeach @foreach ($users as $user) 
               <div class="author-tag">
                  <p class="author">{{ $user->first_name }} {{ $user->last_name }}</p>
                  <p class="title">{{ $user->job_title }}</p>
               </div>
               @endforeach
            </section>
            <section class="proposal-msg">
               <div class="logo">
                  <h1>Keen</h1>
                  <h2>Creative</h2>
               </div>
               @foreach ($users as $user) 
               <div class="user-msg">
                  <p>{!! $user->proposal_message !!}</p>
               </div>
               @endforeach
            </section>
            <section class="scope-list">
               <h3>Proposed Items</h3>
               <ul class="product-list">
                   @foreach ($products as $index => $product)
                   <li class="product-card">
                       <div class="product-info">
                           <span class="product-title">{{ $product->product_name }}</span>
                           <span class="product-price">${{ number_format($product->price, 2) }}</span>
                       </div>
                       <div class="product-description">
                           {!! $projectScopes[$index] !!}
                       </div>
                   </li>
                   @endforeach 
               </ul>
               <div class="total">
                   <p>
                       <span class="bold">Proposal Total:</span> ${{ number_format($step4Data['proposalTotal'], 2) }}
                   </p>
               </div>
           </section>
           
            <section>
               <div>
                  <div>
                     <h3>Privacy Policy</h3>
                     <p>This Privacy Policy governs how Mayvis ("we", "us", or "our") collects, uses, maintains, and discloses information collected from users (each, a "User") of the Mayvis website ("Site"). This privacy policy applies to the Site and all products and services offered by Mayvis.</p>
                  </div>
                  <div>
                     <h4>Information We Collect</h4>
                     <p>We may collect personal identification information from Users in a variety of ways, including, but not limited to, when Users visit our site, register on the site, sign in using Google, and in connection with other activities, services, features, or resources we make available on our Site. Users may be asked for, as appropriate, their name, and email address. Users may, however, visit our Site anonymously. We will collect personal identification information from Users only if they voluntarily submit such information to us. Users can always refuse to supply personal identification information, except that it may prevent them from engaging in certain Site-related activities.</p>
                     <p>We may collect non-personal identification information about Users whenever they interact with our Site. Non-personal identification information may include the browser name, the type of computer, and technical information about Users means of connection to our Site, such as the operating system and the Internet service providers utilized and other similar information.</p>
                  </div>
                  <div>
                     <h4>How We Use Your Information</h4>
                     <p>We use the information we collect to provide and improve our services, personalize your experience, communicate with you, and analyze trends and user behavior on our Site. We do not sell or share your personal information with third parties without your consent.</p>
                  </div>
                  <div>
                     <h4>Information Sharing</h4>
                     <p>We may share non-personal information with third-party service providers to help us operate our Site and deliver services. We may also share aggregated, anonymized information for marketing or analytics purposes.</p>
                  </div>
                  <div>
                     <h4>Your Choices</h4>
                     <p>You have the right to opt-out of receiving promotional communications from us and to limit the collection and use of your information. You can manage your communication preferences by contacting us or adjusting your account settings.</p>
                  </div>
                  <div>
                     <h4>Security</h4>
                     <p>We take reasonable measures to protect your information from unauthorized access, use, or disclosure. However, no method of transmission over the internet or electronic storage is 100% secure, and we cannot guarantee absolute security.</p>
                  </div>
                  <div>
                     <h4>User Agreement</h4>
                     <p>By accessing or using our Site, you agree to be bound by this Privacy Policy. If you do not agree to this Privacy Policy, please do not use our Site. Your use of the Site constitutes your acceptance of this Privacy Policy and your consent to the practices it describes.</p>
                     <p>Account Creation and Conduct: You must create an account using your Google credentials to access certain features of the website. By creating an account, you agree to provide accurate, current, and complete information. You are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer or device. You agree to accept responsibility for all activities that occur under your account.</p>
                     <p>You agree to use the website only for lawful purposes and in a manner consistent with all applicable laws and regulations. You may not use the website in any way that violates any applicable federal, state, local, or international law or regulation, or to engage in any conduct that restricts or inhibits anyone's use or enjoyment of the website, or which, as determined by us, may harm us or users of the website or expose them to liability.</p>
                  </div>
                  <div>
                     <h4>Intellectual Property</h4>
                     <p>All content on the website, including quotes, user-generated content, trademarks, logos, and service marks ("Content"), is protected by intellectual property laws and belongs to Mayvis or its licensors. You may not modify, publish, transmit, participate in the transfer or sale of, reproduce, create derivative works based on, distribute, perform, display, or in any way exploit any of the Content, in whole or in part.</p>
                  </div>
                  <div>
                     <h4>Limitation of Liability</h4>
                     <p>We are not liable for any indirect, incidental, special, consequential, or punitive damages arising out of your use of the website. In no event shall our total liability to you for all damages, losses, or causes of action exceed the amount paid by you, if any, for accessing the website.</p>
                  </div>
                  <div>
                     <h4> Changes to Terms</h4>
                     <p>We reserve the right to modify or replace these terms at any time. Your continued use of the website after any such changes constitutes your acceptance of the new terms. Please review this Privacy Policy periodically for changes. If you do not agree to any of this Privacy Policy or any changes to this Privacy Policy, do not use, access, or continue to access the Site or discontinue any use of the Site immediately.</p>
                     <p>If you have any questions or concerns about our Privacy Policy or User Agreement, please contact us at <a href="mailto:contact@mayvis.com">contact@mayvis.com</a>. </p>
                  </div>
                  <div class="signature">
                     <div class="signature-area">
                        <div class="signature-block">
                           <span>Printed Name and Signature</span>
                        </div>
                        <div class="signature-block">
                           <span>Date</span>
                        </div>
                     </div>
                     <div class="signature-area">
                        <div class="signature-block">
                           <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                        </div>
                        <div class="signature-block">
                           <span>Date</span>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
      </main>
   </body>
</html>