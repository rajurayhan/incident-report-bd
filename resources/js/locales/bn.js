export default {
  nav: {
    logo: 'ইনসিডেন্ট রিপোর্ট বাংলাদেশ',
    home: 'হোম',
    report: 'ঘটনা রিপোর্ট করুন',
    map: 'মানচিত্র',
    analytics: 'বিশ্লেষণ',
    login: 'লগইন',
    register: 'নিবন্ধন',
    profile: 'প্রোফাইল',
    myReports: 'আমার রিপোর্ট',
    myActivity: 'আমার কার্যক্রম',
    logout: 'লগ আউট'
  },
  auth: {
    signIn: 'আপনার অ্যাকাউন্টে সাইন ইন করুন',
    signUp: 'আপনার অ্যাকাউন্ট তৈরি করুন',
    email: 'ইমেল ঠিকানা',
    username: 'ব্যবহারকারীর নাম',
    password: 'পাসওয়ার্ড',
    confirmPassword: 'পাসওয়ার্ড নিশ্চিত করুন',
    name: 'পূর্ণ নাম',
    phone: 'ফোন নম্বর',
    forgotPassword: 'পাসওয়ার্ড ভুলে গেছেন?',
    resetPassword: 'আপনার পাসওয়ার্ড রিসেট করুন',
    signInButton: 'সাইন ইন',
    registerButton: 'অ্যাকাউন্ট তৈরি করুন',
    signingIn: 'সাইন ইন হচ্ছে...',
    creatingAccount: 'অ্যাকাউন্ট তৈরি হচ্ছে...',
    orCreate: 'অথবা একটি নতুন অ্যাকাউন্ট তৈরি করুন',
    orSignIn: 'অথবা বিদ্যমান অ্যাকাউন্টে সাইন ইন করুন',
    loginFailed: 'লগইন ব্যর্থ হয়েছে। আবার চেষ্টা করুন।',
    createAccount: 'আপনার অ্যাকাউন্ট তৈরি করুন',
    orSignInExisting: 'অথবা বিদ্যমান অ্যাকাউন্টে সাইন ইন করুন',
    yourFullName: 'আপনার পূর্ণ নাম',
    uniqueUsername: 'অনন্য_ব্যবহারকারীর_নাম (শুধুমাত্র অক্ষর, সংখ্যা, আন্ডারস্কোর)',
    usernamePattern: 'ব্যবহারকারীর নামে শুধুমাত্র অক্ষর, সংখ্যা এবং আন্ডারস্কোর থাকতে পারে',
    emailAddress: 'ইমেল ঠিকানা',
    phoneNumber: 'ফোন নম্বর',
    phonePlaceholder: '+৮৮০ ১XXX XXXXXX',
    confirmPassword: 'পাসওয়ার্ড নিশ্চিত করুন',
    confirmPasswordPlaceholder: 'পাসওয়ার্ড নিশ্চিত করুন',
    registrationFailed: 'নিবন্ধন ব্যর্থ হয়েছে। আবার চেষ্টা করুন।',
    validation: {
      name: {
        required: 'পূর্ণ নাম প্রয়োজন',
        max: 'নাম ২৫৫ অক্ষরের বেশি হতে পারে না'
      },
      username: {
        required: 'ব্যবহারকারীর নাম প্রয়োজন',
        max: 'ব্যবহারকারীর নাম ৫০ অক্ষরের বেশি হতে পারে না',
        unique: 'এই ব্যবহারকারীর নামটি ইতিমধ্যে নেওয়া হয়েছে',
        regex: 'ব্যবহারকারীর নামে শুধুমাত্র অক্ষর, সংখ্যা এবং আন্ডারস্কোর থাকতে পারে'
      },
      email: {
        required: 'ইমেল ঠিকানা প্রয়োজন',
        email: 'অনুগ্রহ করে একটি বৈধ ইমেল ঠিকানা লিখুন',
        max: 'ইমেল ২৫৫ অক্ষরের বেশি হতে পারে না',
        unique: 'এই ইমেল ঠিকানাটি ইতিমধ্যে নিবন্ধিত'
      },
      password: {
        required: 'পাসওয়ার্ড প্রয়োজন',
        min: 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষর দীর্ঘ হতে হবে',
        confirmed: 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না'
      },
      phone: {
        required: 'ফোন নম্বর প্রয়োজন',
        max: 'ফোন নম্বর ২০ অক্ষরের বেশি হতে পারে না'
      }
    }
  },
  incident: {
    title: 'শিরোনাম',
    description: 'বিবরণ',
    category: 'বিভাগ',
    status: 'অবস্থা',
    priority: 'অগ্রাধিকার',
    location: 'অবস্থান',
    date: 'তারিখ',
    viewDetails: 'বিস্তারিত দেখুন',
    addComment: 'একটি মন্তব্য যোগ করুন',
    postComment: 'মন্তব্য পোস্ট করুন',
    reply: 'জবাব',
    delete: 'মুছে ফেলুন',
    confirm: 'নিশ্চিত করুন',
    dispute: 'বিতর্ক',
    verifyIncident: 'এই ঘটনা যাচাই করুন',
    comments: 'মন্তব্য',
    verifications: 'যাচাইকরণ',
    confirmations: 'নিশ্চিতকরণ',
    disputes: 'বিতর্ক',
    verified: 'যাচাইকৃত',
    noComments: 'এখনো কোনো মন্তব্য নেই। প্রথম মন্তব্য করুন!',
    loadMore: 'আরও মন্তব্য লোড করুন',
    loading: 'লোড হচ্ছে...',
    replyingTo: 'জবাব দিচ্ছেন'
  },
  profile: {
    profile: 'প্রোফাইল',
    updateProfile: 'প্রোফাইল আপডেট করুন',
    changePassword: 'পাসওয়ার্ড পরিবর্তন করুন',
    currentPassword: 'বর্তমান পাসওয়ার্ড',
    newPassword: 'নতুন পাসওয়ার্ড',
    city: 'শহর',
    reportsSubmitted: 'জমা দেওয়া রিপোর্ট',
    verifiedReports: 'যাচাইকৃত রিপোর্ট',
    memberSince: 'সদস্য হওয়ার তারিখ',
    updating: 'আপডেট হচ্ছে...',
    changing: 'পরিবর্তন হচ্ছে...',
    activeAccount: 'সক্রিয় অ্যাকাউন্ট',
    enterYourName: 'আপনার নাম লিখুন',
    yourEmail: 'আপনার ইমেইল ঠিকানা',
    phonePlaceholder: '+৮৮০ ১XXX-XXXXXX',
    yourCity: 'আপনার শহর',
    profileUpdatedSuccessfully: 'প্রোফাইল সফলভাবে আপডেট করা হয়েছে!',
    failedToUpdateProfile: 'প্রোফাইল আপডেট করতে ব্যর্থ',
    errorUpdatingProfile: 'প্রোফাইল আপডেট করার সময় একটি ত্রুটি ঘটেছে',
    updateProfileButton: 'প্রোফাইল আপডেট করুন',
    passwordChangedSuccessfully: 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!',
    failedToChangePassword: 'পাসওয়ার্ড পরিবর্তন করতে ব্যর্থ',
    errorChangingPassword: 'পাসওয়ার্ড পরিবর্তন করার সময় একটি ত্রুটি ঘটেছে',
    enterCurrentPassword: 'আপনার বর্তমান পাসওয়ার্ড লিখুন',
    enterNewPassword: 'নতুন পাসওয়ার্ড লিখুন (সর্বনিম্ন ৮ অক্ষর)',
    confirmNewPassword: 'নতুন পাসওয়ার্ড নিশ্চিত করুন',
    changePasswordButton: 'পাসওয়ার্ড পরিবর্তন করুন'
  },
  activity: {
    myActivity: 'আমার কার্যক্রম',
    viewComments: 'আপনার মন্তব্য এবং যাচাইকরণ দেখুন',
    comments: 'মন্তব্য',
    verifications: 'যাচাইকরণ',
    noCommentsYet: 'আপনি এখনো কোনো ঘটনায় মন্তব্য করেননি।',
    noVerificationsYet: 'আপনি এখনো কোনো ঘটনা যাচাই করেননি।',
    upvotes: 'আপভোট',
    downvotes: 'ডাউনভোট',
    confirmed: 'নিশ্চিত করা হয়েছে',
    disputed: 'বিতর্কিত'
  },
  home: {
    hero: {
      badge: 'কমিউনিটি নিরাপত্তা প্ল্যাটফর্ম',
      title: 'ঘটনা রিপোর্ট করুন,',
      subtitle: 'কমিউনিটিকে নিরাপদ রাখুন',
      description: 'বাংলাদেশ জুড়ে ঘটনা রিপোর্ট এবং ট্র্যাক করার জন্য একটি কমিউনিটি-চালিত প্ল্যাটফর্ম। আপনার এলাকাকে নিরাপদ রাখতে সাহায্য করুন।',
      reportIncident: 'ঘটনা রিপোর্ট করুন',
      viewMap: 'মানচিত্র দেখুন'
    },
    nearbyIncidents: {
      title: 'আপনার কাছাকাছি ঘটনা',
      description: 'আপনার অবস্থান থেকে {radius}কিমি এর মধ্যে রিপোর্ট',
      refresh: 'রিফ্রেশ',
      viewAll: 'সব {count}টি কাছাকাছি ঘটনা দেখুন',
      kmAway: '{distance} কিমি দূরে'
    },
    locationRequest: {
      title: 'আপনার কাছাকাছি ঘটনা দেখুন',
      description: 'আপনার এলাকায় ঘটমান ঘটনা দেখতে অবস্থান অ্যাক্সেস অনুমতি দিন',
      enableLocation: 'অবস্থান সক্রিয় করুন'
    },
    stats: {
      totalReports: 'মোট রিপোর্ট',
      verifiedReports: 'যাচাইকৃত রিপোর্ট',
      activeLocations: 'সক্রিয় অবস্থান',
      resolvedToday: 'আজ সমাধান হয়েছে'
    },
    recentIncidents: {
      title: 'সাম্প্রতিক ঘটনা',
      description: 'আপনার কমিউনিটি থেকে সর্বশেষ রিপোর্ট',
      viewAll: 'সব দেখুন',
      noIncidents: 'এখনো কোনো ঘটনা রিপোর্ট করা হয়নি',
      beFirst: 'প্রথম ঘটনা রিপোর্ট করুন!'
    },
    categories: {
      title: 'রিপোর্ট বিভাগ',
      description: 'বিভাগ অনুযায়ী ঘটনা ব্রাউজ করুন'
    }
  },
  footer: {
    title: 'ইনসিডেন্ট রিপোর্ট বাংলাদেশ',
    description: 'বাংলাদেশ জুড়ে ঘটনা রিপোর্ট এবং ট্র্যাক করার জন্য একটি কমিউনিটি-চালিত প্ল্যাটফর্ম',
    privacyPolicy: 'গোপনীয়তা নীতি',
    termsOfService: 'সেবার শর্তাবলী',
    contact: 'যোগাযোগ',
    copyright: 'সকল অধিকার সংরক্ষিত।'
  },
  report: {
    title: 'ঘটনা রিপোর্ট করুন',
    subtitle: 'ঘটনা রিপোর্ট করে আপনার কমিউনিটিকে নিরাপদ রাখতে সাহায্য করুন। সব রিপোর্ট ডিফল্টভাবে বেনামী।',
    basicInformation: 'মৌলিক তথ্য',
    incidentTitle: 'ঘটনার শিরোনাম',
    incidentTitlePlaceholder: 'ঘটনার সংক্ষিপ্ত বিবরণ',
    detailedDescription: 'বিস্তারিত বিবরণ',
    detailedDescriptionPlaceholder: 'কী ঘটেছে, কখন ঘটেছে এবং অন্যান্য প্রাসঙ্গিক বিবরণ দিন',
    category: 'বিভাগ',
    selectCategory: 'একটি বিভাগ নির্বাচন করুন',
    whenDidThisHappen: 'এটি কখন ঘটেছে?',
    location: 'অবস্থান',
    latitude: 'অক্ষাংশ',
    longitude: 'দ্রাঘিমাংশ',
    address: 'ঠিকানা',
    addressPlaceholder: 'রাস্তার ঠিকানা, এলাকা, শহর',
    division: 'বিভাগ',
    district: 'জেলা',
    thana: 'থানা/উপজেলা',
    selectDivision: 'বিভাগ নির্বাচন করুন',
    selectDistrict: 'জেলা নির্বাচন করুন',
    selectThana: 'থানা/উপজেলা নির্বাচন করুন',
    reporterInformation: 'রিপোর্ট করেছেন',
    anonymousReport: 'বেনামী রিপোর্ট হিসাবে জমা দিন',
    anonymousDescription: 'আপনার ব্যক্তিগত তথ্য শেয়ার করা হবে না',
    provideContactInfo: 'যোগাযোগের তথ্য প্রদান করুন',
    reporterName: 'রিপোর্টারের নাম',
    reporterPhone: 'রিপোর্টারের ফোন',
    mediaUpload: 'মিডিয়া আপলোড',
    uploadMedia: 'মিডিয়া ফাইল আপলোড করুন',
    mediaDescription: 'ঘটনা সম্পর্কিত ছবি বা ভিডিও আপলোড করুন (ঐচ্ছিক)',
    dragDropFiles: 'এখানে ফাইল টেনে আনুন, অথবা নির্বাচন করতে ক্লিক করুন',
    supportedFormats: 'সমর্থিত ফরম্যাট: JPG, PNG, GIF, MP4, MOV (প্রতিটি সর্বোচ্চ ১০MB)',
    removeFile: 'মুছে ফেলুন',
    cancel: 'বাতিল',
    submitReport: 'রিপোর্ট জমা দিন',
    submitting: 'জমা দেওয়া হচ্ছে...',
    successMessage: 'ঘটনা সফলভাবে রিপোর্ট করা হয়েছে! কমিউনিটিকে নিরাপদ রাখতে সাহায্য করার জন্য ধন্যবাদ।',
    errorMessage: 'রিপোর্ট জমা দিতে ব্যর্থ। আবার চেষ্টা করুন।',
    validation: {
      title: {
        required: 'ঘটনার শিরোনাম প্রয়োজন',
        max: 'শিরোনাম ২৫৫ অক্ষরের বেশি হতে পারে না'
      },
      description: {
        required: 'বিস্তারিত বিবরণ প্রয়োজন'
      },
      category: {
        required: 'অনুগ্রহ করে একটি বিভাগ নির্বাচন করুন',
        in: 'অনুগ্রহ করে একটি বৈধ বিভাগ নির্বাচন করুন'
      },
      incident_date: {
        date: 'অনুগ্রহ করে একটি বৈধ তারিখ লিখুন'
      },
      latitude: {
        numeric: 'অক্ষাংশ একটি বৈধ সংখ্যা হতে হবে',
        between: 'অক্ষাংশ -৯০ এবং ৯০ এর মধ্যে হতে হবে'
      },
      longitude: {
        numeric: 'দ্রাঘিমাংশ একটি বৈধ সংখ্যা হতে হবে',
        between: 'দ্রাঘিমাংশ -১৮০ এবং ১৮০ এর মধ্যে হতে হবে'
      },
      address: {
        max: 'ঠিকানা ৫০০ অক্ষরের বেশি হতে পারে না'
      },
      city: {
        max: 'শহরের নাম ২৫৫ অক্ষরের বেশি হতে পারে না'
      },
      district: {
        max: 'জেলার নাম ২৫৫ অক্ষরের বেশি হতে পারে না'
      },
      division: {
        max: 'বিভাগের নাম ২৫৫ অক্ষরের বেশি হতে পারে না'
      },
      reporter_name: {
        max: 'রিপোর্টারের নাম ২৫৫ অক্ষরের বেশি হতে পারে না'
      },
      reporter_phone: {
        max: 'রিপোর্টারের ফোন ২০ অক্ষরের বেশি হতে পারে না'
      },
      reporter_email: {
        email: 'অনুগ্রহ করে একটি বৈধ ইমেল ঠিকানা লিখুন',
        max: 'ইমেল ২৫৫ অক্ষরের বেশি হতে পারে না'
      },
      media: {
        array: 'মিডিয়া ফাইলের একটি অ্যারে হতে হবে',
        file: 'প্রতিটি মিডিয়া আইটেম একটি বৈধ ফাইল হতে হবে',
        mimes: 'মিডিয়া ফাইল JPG, JPEG, PNG, GIF, MP4, AVI, বা MOV ফরম্যাটে হতে হবে',
        max: 'প্রতিটি মিডিয়া ফাইল ১০MB এর বেশি হতে পারে না'
      }
    },
    tip: 'পরামর্শ:',
    tipMessage: 'স্থানাঙ্ক স্বয়ংক্রিয়ভাবে পূরণ করতে "বর্তমান অবস্থান পান" ক্লিক করুন, অথবা সেগুলি ম্যানুয়ালি প্রবেশ করান।',
    getCurrentLocation: 'বর্তমান অবস্থান পান',
    mediaOptional: 'মিডিয়া (ঐচ্ছিক)',
    uploadPhotosVideos: 'ছবি বা ভিডিও আপলোড করুন',
    supportedFormatsShort: 'PNG, JPG, MP4 প্রতিটি সর্বোচ্চ ১০MB',
    files: 'ফাইল',
    reportAnonymously: 'বেনামী রিপোর্ট করুন (নিরাপত্তার জন্য সুপারিশকৃত)',
    yourName: 'আপনার নাম',
    yourFullNamePlaceholder: 'আপনার পূর্ণ নাম',
    phoneNumber: 'ফোন নম্বর',
    geolocationNotSupported: 'এই ব্রাউজার দ্বারা জিওলোকেশন সমর্থিত নয়।',
    unableToGetLocation: 'আপনার অবস্থান পাওয়া যাচ্ছে না। অনুগ্রহ করে স্থানাঙ্ক ম্যানুয়ালি প্রবেশ করান।',
    fileTooLarge: 'ফাইল {fileName} খুব বড়। সর্বোচ্চ আকার ১০MB।',
    maxFilesReached: 'সর্বোচ্চ ৩টি ফাইল অনুমোদিত। নতুন ফাইল যোগ করার আগে কিছু ফাইল সরান।',
    maxFilesExceeded: 'আপনি সর্বোচ্চ ৩টি ফাইল আপলোড করতে পারেন।'
  },
  map: {
    title: 'ঘটনা মানচিত্র',
    subtitle: 'ঘটনা ভিজ্যুয়ালাইজেশন এবং ফিল্টার সহ ইন্টারঅ্যাক্টিভ মানচিত্র',
    view: 'দেখুন',
    incidents: 'ঘটনা',
    incidentList: 'ঘটনার তালিকা',
    clickToHighlight: 'মানচিত্রে হাইলাইট করতে ক্লিক করুন',
    loadingIncidents: 'ঘটনা লোড হচ্ছে...',
    noIncidentsFound: 'কোনো ঘটনা পাওয়া যায়নি',
    tryAdjustingFilters: 'আপনার ফিল্টার সামঞ্জস্য করুন',
    loadingMore: 'আরও লোড হচ্ছে...',
    noMoreIncidents: 'লোড করার জন্য আর কোনো ঘটনা নেই',
    loadingMap: 'মানচিত্র লোড হচ্ছে...',
    fitToData: 'ডেটায় ফিট করুন',
    clearSelection: 'নির্বাচন সাফ করুন',
    legend: 'লেজেন্ড',
    urgent: 'জরুরি',
    high: 'উচ্চ',
    medium: 'মধ্যম',
    low: 'নিম্ন',
    verified: 'যাচাইকৃত',
    unverified: 'অযাচাইকৃত',
    heatMapDescription: 'ঘটনার ঘনত্ব দেখায় - লাল এলাকাগুলি ঘটনার উচ্চ ঘনত্ব নির্দেশ করে',
    markersDescription: 'বিস্তারিত পপআপ সহ পৃথক ঘটনার অবস্থান',
    verifications: 'যাচাইকরণ',
    files: 'ফাইল',
    category: 'বিভাগ',
    status: 'অবস্থা',
    priority: 'অগ্রাধিকার',
    location: 'অবস্থান',
    date: 'তারিখ',
    media: 'মিডিয়া',
    viewDetails: 'বিস্তারিত দেখুন',
    unknown: 'অজানা',
    markers: 'মার্কার',
    heatMap: 'হিট ম্যাপ',
    disputes: 'বিতর্ক'
  },
  filters: {
    title: 'ফিল্টার',
    active: 'সক্রিয়',
    category: 'বিভাগ',
    status: 'অবস্থা',
    verified: 'যাচাইকৃত',
    more: 'আরও',
    less: 'কম',
    clear: 'সাফ',
    division: 'বিভাগ',
    district: 'জেলা',
    thanaUpazila: 'থানা / উপজেলা',
    fromDate: 'শুরুর তারিখ',
    toDate: 'শেষ তারিখ',
    allDivisions: 'সব বিভাগ',
    allDistricts: 'সব জেলা',
    allThanas: 'সব থানা',
    categories: {
      theftRobbery: 'চুরি / ডাকাতি',
      sexualHarassment: 'যৌন হয়রানি',
      domesticViolence: 'গার্হস্থ্য সহিংসতা',
      suspiciousActivities: 'সন্দেহজনক কার্যক্রম',
      trafficAccidents: 'যানবাহন দুর্ঘটনা',
      drugs: 'মাদক',
      cybercrime: 'সাইবার অপরাধ'
    },
    statuses: {
      pending: 'মুলতবি',
      inProgress: 'চলমান',
      resolved: 'সমাধান'
    }
  },
  incidentDetails: {
    error: 'ত্রুটি',
    reported: 'রিপোর্ট করা হয়েছে',
    incidentDate: 'ঘটনার তারিখ',
    description: 'বিবরণ',
    location: 'অবস্থান',
    address: 'ঠিকানা',
    area: 'এলাকা',
    coordinates: 'স্থানাঙ্ক',
    center: 'কেন্দ্র',
    incidentLocation: 'ঘটনার অবস্থান',
    openInGoogleMaps: 'গুগল ম্যাপে খুলুন',
    copyCoordinates: 'স্থানাঙ্ক কপি করুন',
    reporterInformation: 'রিপোর্ট করেছেন',
    media: 'মিডিয়া',
    verificationStatus: 'যাচাইকরণের অবস্থা',
    confirmations: 'নিশ্চিতকরণ',
    disputes: 'বিতর্ক',
    verified: 'যাচাইকৃত',
    verifyThisIncident: 'এই ঘটনাটি যাচাই করুন',
    confirm: 'নিশ্চিত করুন',
    dispute: 'বিতর্ক',
    addCommentOptional: 'একটি মন্তব্য যোগ করুন (ঐচ্ছিক)',
    alreadyVerified: 'আপনি ইতিমধ্যে এই ঘটনাটি যাচাই করেছেন',
    comments: 'মন্তব্য',
    replyingTo: 'উত্তর দিচ্ছেন',
    addComment: 'একটি মন্তব্য যোগ করুন...',
    cancel: 'বাতিল',
    postReply: 'উত্তর পোস্ট করুন',
    postComment: 'মন্তব্য পোস্ট করুন',
    reply: 'উত্তর',
    delete: 'মুছে ফেলুন',
    noCommentsYet: 'এখনও কোনো মন্তব্য নেই। প্রথম মন্তব্যকারী হন!',
    loading: 'লোড হচ্ছে...',
    loadMoreComments: 'আরও মন্তব্য লোড করুন',
    nearbyIncidents: 'কাছাকাছি ঘটনা',
    incidentNotFound: 'ঘটনা পাওয়া যায়নি',
    incidentNotFoundDescription: 'আপনি যে ঘটনাটি খুঁজছেন তা বিদ্যমান নেই বা সরানো হয়েছে।',
    failedToAddComment: 'মন্তব্য যোগ করতে ব্যর্থ। অনুগ্রহ করে আবার চেষ্টা করুন।',
    areYouSureDeleteComment: 'আপনি কি নিশ্চিত যে আপনি এই মন্তব্যটি মুছে ফেলতে চান?',
    failedToDeleteComment: 'মন্তব্য মুছে ফেলতে ব্যর্থ। অনুগ্রহ করে আবার চেষ্টা করুন।',
    alreadyVerifiedAlert: 'আপনি ইতিমধ্যে এই ঘটনাটি যাচাই করেছেন।',
    failedToVerifyIncident: 'ঘটনা যাচাই করতে ব্যর্থ। অনুগ্রহ করে আবার চেষ্টা করুন।',
    locationCoordinates: 'অবস্থানের স্থানাঙ্ক',
    unknownStatus: 'অজানা অবস্থা',
    unknownPriority: 'অজানা অগ্রাধিকার',
    priority: {
      low: 'নিম্ন',
      medium: 'মধ্যম',
      high: 'উচ্চ',
      urgent: 'জরুরি'
    }
  },
  analytics: {
    title: 'বিশ্লেষণ ড্যাশবোর্ড',
    subtitle: 'ব্যাপক অন্তর্দৃষ্টি এবং পরিসংখ্যান',
    totalReports: 'মোট রিপোর্ট',
    verifiedReports: 'যাচাইকৃত রিপোর্ট',
    activeLocations: 'সক্রিয় অবস্থান',
    resolvedToday: 'আজ সমাধান হয়েছে',
    allTimeSubmissions: 'সব সময়ের জমা',
    verificationRate: 'যাচাইকরণের হার',
    districtsWithReports: 'রিপোর্ট সহ জেলা',
    casesClosedToday: 'আজ বন্ধ হওয়া মামলা',
    reportsByCategory: 'বিভাগ অনুযায়ী রিপোর্ট',
    reportsByStatus: 'অবস্থা অনুযায়ী রিপোর্ট',
    topLocations: 'শীর্ষ অবস্থান',
    noLocationData: 'এখনো কোনো অবস্থানের ডেটা নেই',
    categories: {
      theftRobbery: 'চুরি / ডাকাতি',
      sexualHarassment: 'যৌন হয়রানি',
      domesticViolence: 'গার্হস্থ্য সহিংসতা',
      suspiciousActivities: 'সন্দেহজনক কার্যক্রম',
      trafficAccidents: 'যানবাহন দুর্ঘটনা',
      drugs: 'মাদক',
      cybercrime: 'সাইবার অপরাধ'
    },
    statuses: {
      pending: 'মুলতবি',
      inProgress: 'চলমান',
      resolved: 'সমাধান'
    }
  },
  myReports: {
    title: 'আমার রিপোর্ট',
    subtitle: 'আপনার ঘটনা রিপোর্ট দেখুন এবং পরিচালনা করুন',
    totalReports: 'মোট রিপোর্ট',
    pending: 'মুলতবি',
    investigating: 'তদন্ত চলছে',
    resolved: 'সমাধান',
    verified: 'যাচাইকৃত',
    allReports: 'সব রিপোর্ট',
    noReportsFound: 'কোনো রিপোর্ট পাওয়া যায়নি',
    noReportsDescription: 'আপনি এখনো কোনো {type} রিপোর্ট জমা দেননি।',
    submitFirstReport: 'আপনার প্রথম রিপোর্ট জমা দিন',
    loading: 'আপনার রিপোর্ট লোড হচ্ছে...',
    viewDetails: 'বিস্তারিত দেখুন',
    categories: {
      fire: 'আগুন',
      accident: 'দুর্ঘটনা',
      crime: 'অপরাধ',
      naturalDisaster: 'প্রাকৃতিক দুর্যোগ',
      health: 'স্বাস্থ্য',
      other: 'অন্যান্য'
    },
    statuses: {
      pending: 'মুলতবি',
      investigating: 'তদন্ত চলছে',
      resolved: 'সমাধান',
      rejected: 'প্রত্যাখ্যান'
    }
  },
  signUpInfo: {
    title: 'নিবন্ধন প্রয়োজন',
    message: 'ঘটনা রিপোর্ট করতে আপনাকে সাইন ইন করতে হবে। চালিয়ে যেতে দয়া করে একটি অ্যাকাউন্ট তৈরি করুন বা সাইন ইন করুন।',
    benefits: {
      title: 'নিবন্ধনের সুবিধা:',
      trackReports: 'আপনার ঘটনা রিপোর্ট ট্র্যাক করুন',
      getUpdates: 'আপনার রিপোর্টের আপডেট পান',
      verifyIncidents: 'আপনার এলাকার অন্যান্য ঘটনা যাচাই করুন',
      contribute: 'সম্প্রদায়ের নিরাপত্তায় অবদান রাখুন'
    },
    signUpButton: 'অ্যাকাউন্ট তৈরি করুন',
    signInButton: 'সাইন ইন'
  },
  commentLogin: {
    title: 'মন্তব্য করতে সাইন ইন করুন',
    message: 'মন্তব্য যোগ করতে এবং আলোচনায় অংশ নিতে দয়া করে সাইন ইন করুন।',
    signInButton: 'সাইন ইন',
    signUpButton: 'অ্যাকাউন্ট তৈরি করুন'
  },
}

