export default {
  nav: {
    logo: 'IncidentReport Bangladesh',
    home: 'Home',
    report: 'Report Incident',
    map: 'Map',
    analytics: 'Analytics',
    login: 'Login',
    register: 'Register',
    profile: 'Profile',
    myReports: 'My Reports',
    myActivity: 'My Activity',
    logout: 'Logout'
  },
  auth: {
    signIn: 'Sign in to your account',
    signUp: 'Create your account',
    email: 'Email address',
    username: 'Username',
    password: 'Password',
    confirmPassword: 'Confirm Password',
    name: 'Full Name',
    phone: 'Phone Number',
    forgotPassword: 'Forgot your password?',
    resetPassword: 'Reset your password',
    signInButton: 'Sign in',
    registerButton: 'Create account',
    signingIn: 'Signing in...',
    creatingAccount: 'Creating account...',
    orCreate: 'Or create a new account',
    orSignIn: 'Or sign in to existing account',
    loginFailed: 'Login failed. Please try again.',
    createAccount: 'Create your account',
    orSignInExisting: 'Or sign in to existing account',
    yourFullName: 'Your full name',
    uniqueUsername: 'unique_username (letters, numbers, underscore only)',
    usernamePattern: 'Username can only contain letters, numbers, and underscores',
    emailAddress: 'Email Address',
    phoneNumber: 'Phone Number',
    phonePlaceholder: '+880 1XXX XXXXXX',
    confirmPassword: 'Confirm Password',
    confirmPasswordPlaceholder: 'Confirm password',
    registrationFailed: 'Registration failed. Please try again.',
    validation: {
      name: {
        required: 'Full name is required',
        max: 'Name must not exceed 255 characters'
      },
      username: {
        required: 'Username is required',
        max: 'Username must not exceed 50 characters',
        unique: 'This username is already taken',
        regex: 'Username can only contain letters, numbers, and underscores'
      },
      email: {
        required: 'Email address is required',
        email: 'Please enter a valid email address',
        max: 'Email must not exceed 255 characters',
        unique: 'This email address is already registered'
      },
      password: {
        required: 'Password is required',
        min: 'Password must be at least 8 characters long',
        confirmed: 'Password confirmation does not match'
      },
      phone: {
        required: 'Phone number is required',
        max: 'Phone number must not exceed 20 characters'
      }
    }
  },
  incident: {
    title: 'Title',
    description: 'Description',
    category: 'Category',
    status: 'Status',
    priority: 'Priority',
    location: 'Location',
    date: 'Date',
    viewDetails: 'View Details',
    addComment: 'Add a comment',
    postComment: 'Post Comment',
    reply: 'Reply',
    delete: 'Delete',
    confirm: 'Confirm',
    dispute: 'Dispute',
    verifyIncident: 'Verify this incident',
    comments: 'Comments',
    verifications: 'Verifications',
    confirmations: 'Confirmations',
    disputes: 'Disputes',
    verified: 'Verified',
    noComments: 'No comments yet. Be the first to comment!',
    loadMore: 'Load More Comments',
    loading: 'Loading...',
    replyingTo: 'Replying to'
  },
  profile: {
    profile: 'Profile',
    updateProfile: 'Update Profile',
    changePassword: 'Change Password',
    currentPassword: 'Current Password',
    newPassword: 'New Password',
    city: 'City',
    reportsSubmitted: 'Reports Submitted',
    verifiedReports: 'Verified Reports',
    memberSince: 'Member Since',
    updating: 'Updating...',
    changing: 'Changing...',
    activeAccount: 'Active Account',
    enterYourName: 'Enter your name',
    yourEmail: 'Your email address',
    phonePlaceholder: '+880 1XXX-XXXXXX',
    yourCity: 'Your city',
    profileUpdatedSuccessfully: 'Profile updated successfully!',
    failedToUpdateProfile: 'Failed to update profile',
    errorUpdatingProfile: 'An error occurred while updating profile',
    updateProfileButton: 'Update Profile',
    passwordChangedSuccessfully: 'Password changed successfully!',
    failedToChangePassword: 'Failed to change password',
    errorChangingPassword: 'An error occurred while changing password',
    enterCurrentPassword: 'Enter your current password',
    enterNewPassword: 'Enter new password (min 8 characters)',
    confirmNewPassword: 'Confirm new password',
    changePasswordButton: 'Change Password'
  },
  activity: {
    myActivity: 'My Activity',
    viewComments: 'View your comments and verifications',
    comments: 'Comments',
    verifications: 'Verifications',
    noCommentsYet: "You haven't commented on any incidents yet.",
    noVerificationsYet: "You haven't verified any incidents yet.",
    upvotes: 'upvotes',
    downvotes: 'downvotes',
    confirmed: 'Confirmed',
    disputed: 'Disputed'
  },
  home: {
    hero: {
      badge: 'Community Safety Platform',
      title: 'Report Incidents,',
      subtitle: 'Keep Communities Safe',
      description: 'A community-driven platform for reporting and tracking incidents across Bangladesh. Help keep your neighborhood safe.',
      reportIncident: 'Report Incident',
      viewMap: 'View Map'
    },
    nearbyIncidents: {
      title: 'Incidents Near You',
      description: 'Reports within {radius}km of your location',
      refresh: 'Refresh',
      viewAll: 'View all {count} nearby incidents',
      kmAway: '{distance} km away'
    },
    locationRequest: {
      title: 'See Incidents Near You',
      description: 'Allow location access to view incidents happening in your area',
      enableLocation: 'Enable Location'
    },
    stats: {
      totalReports: 'Total Reports',
      verifiedReports: 'Verified Reports',
      activeLocations: 'Active Locations',
      resolvedToday: 'Resolved Today'
    },
    recentIncidents: {
      title: 'Recent Incidents',
      description: 'Latest reports from your community',
      viewAll: 'View All',
      noIncidents: 'No incidents reported yet',
      beFirst: 'Be the first to report an incident!'
    },
    categories: {
      title: 'Report Categories',
      description: 'Browse incidents by category'
    }
  },
  footer: {
    title: 'IncidentReport Bangladesh',
    description: 'A community-driven platform for reporting and tracking incidents across Bangladesh',
    privacyPolicy: 'Privacy Policy',
    termsOfService: 'Terms of Service',
    contact: 'Contact',
    copyright: 'All rights reserved.'
  },
  report: {
    title: 'Report an Incident',
    subtitle: 'Help keep your community safe by reporting incidents. All reports are anonymous by default.',
    basicInformation: 'Basic Information',
    incidentTitle: 'Incident Title',
    incidentTitlePlaceholder: 'Brief description of the incident',
    detailedDescription: 'Detailed Description',
    detailedDescriptionPlaceholder: 'Provide detailed information about what happened, when, and any other relevant details',
    category: 'Category',
    selectCategory: 'Select a category',
    whenDidThisHappen: 'When did this happen?',
    location: 'Location',
    latitude: 'Latitude',
    longitude: 'Longitude',
    address: 'Address',
    addressPlaceholder: 'Street address, area, city',
    division: 'Division',
    district: 'District',
    thana: 'Thana/Upazila',
    selectDivision: 'Select Division',
    selectDistrict: 'Select District',
    selectThana: 'Select Thana/Upazila',
    mediaUpload: 'Media Upload',
    uploadMedia: 'Upload Media Files',
    mediaDescription: 'Upload photos or videos related to the incident (optional)',
    dragDropFiles: 'Drag and drop files here, or click to select',
    supportedFormats: 'Supported formats: JPG, PNG, GIF, MP4, MOV (Max 10MB each)',
    removeFile: 'Remove',
    cancel: 'Cancel',
    submitReport: 'Submit Report',
    submitting: 'Submitting...',
    successMessage: 'Incident reported successfully! Thank you for helping keep the community safe.',
    errorMessage: 'Failed to submit report. Please try again.',
    validation: {
      title: {
        required: 'Incident title is required',
        max: 'Title must not exceed 255 characters'
      },
      description: {
        required: 'Detailed description is required'
      },
      category: {
        required: 'Please select a category',
        in: 'Please select a valid category'
      },
      incident_date: {
        date: 'Please enter a valid date'
      },
      latitude: {
        numeric: 'Latitude must be a valid number',
        between: 'Latitude must be between -90 and 90'
      },
      longitude: {
        numeric: 'Longitude must be a valid number',
        between: 'Longitude must be between -180 and 180'
      },
      address: {
        max: 'Address must not exceed 500 characters'
      },
      city: {
        max: 'City name must not exceed 255 characters'
      },
      district: {
        max: 'District name must not exceed 255 characters'
      },
      division: {
        max: 'Division name must not exceed 255 characters'
      },
      media: {
        array: 'Media must be an array of files',
        file: 'Each media item must be a valid file',
        mimes: 'Media files must be JPG, JPEG, PNG, GIF, MP4, AVI, or MOV format',
        max: 'Each media file must not exceed 10MB'
      }
    },
    tip: 'Tip:',
    tipMessage: 'Click "Get Current Location" to automatically fill coordinates, or manually enter them.',
    getCurrentLocation: 'Get Current Location',
    mediaOptional: 'Media (Optional)',
    uploadPhotosVideos: 'Upload photos or videos',
    supportedFormatsShort: 'PNG, JPG, MP4 up to 10MB each',
    files: 'files',
    yourName: 'Your Name',
    yourFullNamePlaceholder: 'Your full name',
    phoneNumber: 'Phone Number',
    geolocationNotSupported: 'Geolocation is not supported by this browser.',
    unableToGetLocation: 'Unable to get your location. Please enter coordinates manually.',
    locationDetected: 'Location detected successfully!',
    fileTooLarge: 'File {fileName} is too large. Maximum size is 10MB.',
    maxFilesReached: 'Maximum 3 files allowed. Please remove some files before adding new ones.',
    maxFilesExceeded: 'You can only upload a maximum of 3 files.',
    validationError: 'Please check the form for errors.',
    mapPinSelector: {
      title: 'Select Incident Location',
      getCurrentLocation: 'Get Current Location',
      clearPin: 'Clear Pin',
      loadingMap: 'Loading map...',
      clickToDropPin: 'Click on the map to drop a pin at the incident location',
      selectedLocation: 'Selected Location',
      copyCoordinates: 'Copy Coordinates',
      incidentLocation: 'Incident Location',
      coordinatesCopied: 'Coordinates copied to clipboard!',
      copyFailed: 'Failed to copy coordinates'
    }
  },
  map: {
    title: 'Incident Map',
    subtitle: 'Interactive map with incident visualization and filters',
    view: 'View',
    incidents: 'incidents',
    incidentList: 'Incident List',
    clickToHighlight: 'Click to highlight on map',
    loadingIncidents: 'Loading incidents...',
    noIncidentsFound: 'No incidents found',
    tryAdjustingFilters: 'Try adjusting your filters',
    loadingMore: 'Loading more...',
    noMoreIncidents: 'No more incidents to load',
    loadingMap: 'Loading map...',
    fitToData: 'Fit to Data',
    clearSelection: 'Clear Selection',
    legend: 'Legend',
    urgent: 'Urgent',
    high: 'High',
    medium: 'Medium',
    low: 'Low',
    verified: 'Verified',
    unverified: 'Unverified',
    heatMapDescription: 'Shows incident density - red areas indicate higher concentration of incidents',
    markersDescription: 'Individual incident locations with detailed popups',
    verifications: 'verifications',
    files: 'files',
    category: 'Category',
    status: 'Status',
    priority: 'Priority',
    location: 'Location',
    date: 'Date',
    media: 'Media',
    viewDetails: 'View Details',
    unknown: 'Unknown',
    markers: 'Markers',
    heatMap: 'Heat Map',
    disputes: 'disputes'
  },
  filters: {
    title: 'Filters',
    active: 'active',
    category: 'Category',
    status: 'Status',
    verified: 'Verified',
    more: 'More',
    less: 'Less',
    clear: 'Clear',
    division: 'Division',
    district: 'District',
    thanaUpazila: 'Thana / Upazila',
    fromDate: 'From Date',
    toDate: 'To Date',
    allDivisions: 'All Divisions',
    allDistricts: 'All Districts',
    allThanas: 'All Thanas',
    categories: {
      theftRobbery: 'Theft / Robbery',
      sexualHarassment: 'Sexual Harassment',
      domesticViolence: 'Domestic Violence',
      suspiciousActivities: 'Suspicious Activities',
      trafficAccidents: 'Traffic Accidents',
      drugs: 'Drugs',
      cybercrime: 'Cybercrime'
    },
    statuses: {
      pending: 'Pending',
      inProgress: 'In Progress',
      resolved: 'Resolved'
    }
  },
  incidentDetails: {
    error: 'Error',
    reported: 'Reported',
    incidentDate: 'Incident Date',
    description: 'Description',
    location: 'Location',
    address: 'Address',
    area: 'Area',
    coordinates: 'Coordinates',
    center: 'Center',
    incidentLocation: 'Incident Location',
    openInGoogleMaps: 'Open in Google Maps',
    copyCoordinates: 'Copy Coordinates',
    media: 'Media',
    verificationStatus: 'Verification Status',
    confirmations: 'Confirmations',
    disputes: 'Disputes',
    verified: 'Verified',
    verifyThisIncident: 'Verify this incident',
    confirm: 'Confirm',
    dispute: 'Dispute',
    addCommentOptional: 'Add a comment (optional)',
    alreadyVerified: 'You have already verified this incident',
    comments: 'Comments',
    replyingTo: 'Replying to',
    addComment: 'Add a comment... (Use @ symbol to mention users)',
    cancel: 'Cancel',
    postReply: 'Post Reply',
    postComment: 'Post Comment',
    reply: 'Reply',
    delete: 'Delete',
    noCommentsYet: 'No comments yet. Be the first to comment!',
    loading: 'Loading...',
    loadMoreComments: 'Load More Comments',
    nearbyIncidents: 'Nearby Incidents',
    incidentNotFound: 'Incident Not Found',
    incidentNotFoundDescription: 'The incident you\'re looking for doesn\'t exist or has been removed.',
    failedToAddComment: 'Failed to add comment. Please try again.',
    areYouSureDeleteComment: 'Are you sure you want to delete this comment?',
    failedToDeleteComment: 'Failed to delete comment. Please try again.',
    alreadyVerifiedAlert: 'You have already verified this incident.',
    failedToVerifyIncident: 'Failed to verify incident. Please try again.',
    locationCoordinates: 'Location coordinates',
    unknownStatus: 'Unknown Status',
    unknownPriority: 'Unknown Priority',
    priority: {
      low: 'Low',
      medium: 'Medium',
      high: 'High',
      urgent: 'Urgent'
    }
  },
  analytics: {
    title: 'Analytics Dashboard',
    subtitle: 'Comprehensive insights and statistics',
    totalReports: 'Total Reports',
    verifiedReports: 'Verified Reports',
    activeLocations: 'Active Locations',
    resolvedToday: 'Resolved Today',
    allTimeSubmissions: 'All time submissions',
    verificationRate: 'verification rate',
    districtsWithReports: 'Districts with reports',
    casesClosedToday: 'Cases closed today',
    reportsByCategory: 'Reports by Category',
    reportsByStatus: 'Reports by Status',
    topLocations: 'Top Locations',
    noLocationData: 'No location data available yet',
    categories: {
      theftRobbery: 'Theft / Robbery',
      sexualHarassment: 'Sexual Harassment',
      domesticViolence: 'Domestic Violence',
      suspiciousActivities: 'Suspicious Activities',
      trafficAccidents: 'Traffic Accidents',
      drugs: 'Drugs',
      cybercrime: 'Cybercrime'
    },
    statuses: {
      pending: 'Pending',
      inProgress: 'In Progress',
      resolved: 'Resolved'
    }
  },
  myReports: {
    title: 'My Reports',
    subtitle: 'View and manage your incident reports',
    totalReports: 'Total Reports',
    pending: 'Pending',
    investigating: 'Investigating',
    resolved: 'Resolved',
    verified: 'Verified',
    allReports: 'All Reports',
    noReportsFound: 'No reports found',
    noReportsDescription: 'You haven\'t submitted any {type} reports yet.',
    submitFirstReport: 'Submit Your First Report',
    loading: 'Loading your reports...',
    viewDetails: 'View Details',
    categories: {
      fire: 'Fire',
      accident: 'Accident',
      crime: 'Crime',
      naturalDisaster: 'Natural Disaster',
      health: 'Health',
      other: 'Other'
    },
    statuses: {
      pending: 'Pending',
      investigating: 'Investigating',
      resolved: 'Resolved',
      rejected: 'Rejected'
    }
  },
  signUpInfo: {
    title: 'Sign Up Required',
    message: 'You need to be signed in to report an incident. Please create an account or sign in to continue.',
    benefits: {
      title: 'Benefits of signing up:',
      trackReports: 'Track your incident reports',
      getUpdates: 'Receive updates on your reports',
      verifyIncidents: 'Verify other incidents in your area',
      contribute: 'Contribute to community safety'
    },
    signUpButton: 'Create Account',
    signInButton: 'Sign In'
  },
  commentLogin: {
    title: 'Sign In to Comment',
    message: 'Please sign in to add comments and participate in the discussion.',
    signInButton: 'Sign In',
    signUpButton: 'Create Account'
  },
  privacyPolicy: {
    title: 'Privacy Policy',
    lastUpdated: 'Last updated: January 2025',
    backButton: 'Go Back',
    introduction: {
      title: 'Introduction',
      content: 'IncidentReport Bangladesh ("we," "our," or "us") is committed to protecting your privacy and personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our incident reporting platform and related services.'
    },
    informationWeCollect: {
      title: 'Information We Collect',
      personalInfo: {
        title: 'Personal Information',
        name: 'Full name and contact information',
        email: 'Email address for account management and communications',
        phone: 'Phone number for verification and emergency contact',
        username: 'Unique username for platform identification',
        location: 'General location information (city, district, division)'
      },
      incidentInfo: {
        title: 'Incident Information',
        description: 'Detailed descriptions of reported incidents',
        location: 'Specific location data including GPS coordinates',
        media: 'Photos, videos, and other media files related to incidents',
        timestamp: 'Date and time of incident occurrence and reporting'
      },
      technicalInfo: {
        title: 'Technical Information',
        ipAddress: 'IP address and device identifiers',
        browser: 'Browser type, version, and settings',
        device: 'Device information including operating system',
        cookies: 'Cookies and similar tracking technologies'
      }
    },
    howWeUseInfo: {
      title: 'How We Use Your Information',
      provideService: 'Provide and maintain our incident reporting services',
      communicate: 'Send you important updates, notifications, and responses',
      improve: 'Improve our platform functionality and user experience',
      analytics: 'Analyze usage patterns and generate statistical reports',
      security: 'Ensure platform security and prevent fraudulent activities',
      legal: 'Comply with legal obligations and law enforcement requests'
    },
    informationSharing: {
      title: 'Information Sharing and Disclosure',
      content: 'We do not sell, trade, or rent your personal information to third parties. We may share your information only in the following limited circumstances:',
      whenWeShare: {
        title: 'When We Share Information',
        consent: 'With your explicit consent',
        legal: 'To comply with legal requirements or court orders',
        emergency: 'In emergency situations to protect public safety',
        anonymized: 'As aggregated, anonymized data for research purposes'
      }
    },
    dataSecurity: {
      title: 'Data Security',
      content: 'We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.',
      encryption: 'Data encryption in transit and at rest',
      access: 'Restricted access to personal information on a need-to-know basis',
      monitoring: 'Regular security monitoring and vulnerability assessments',
      backup: 'Secure backup and recovery procedures'
    },
    yourRights: {
      title: 'Your Rights',
      access: 'Access your personal information we hold',
      correction: 'Correct inaccurate or incomplete information',
      deletion: 'Request deletion of your personal information',
      portability: 'Receive a copy of your data in a portable format',
      objection: 'Object to processing of your personal information',
      withdraw: 'Withdraw consent for data processing activities'
    },
    cookies: {
      title: 'Cookies and Tracking Technologies',
      content: 'We use cookies and similar technologies to enhance your experience on our platform.',
      essential: 'Essential cookies for basic platform functionality',
      analytics: 'Analytics cookies to understand usage patterns',
      preferences: 'Preference cookies to remember your settings',
      marketing: 'Marketing cookies for targeted communications (with consent)'
    },
    dataRetention: {
      title: 'Data Retention',
      content: 'We retain your personal information only for as long as necessary to fulfill the purposes outlined in this Privacy Policy.',
      incidentData: 'Incident reports: 7 years for legal and safety purposes',
      userData: 'User account information: Until account deletion',
      analytics: 'Analytics data: 2 years in anonymized form',
      legal: 'Legal compliance data: As required by applicable laws'
    },
    childrensPrivacy: {
      title: "Children's Privacy",
      content: 'Our services are not intended for children under 13 years of age. We do not knowingly collect personal information from children under 13. If you are a parent or guardian and believe your child has provided us with personal information, please contact us immediately.'
    },
    internationalTransfers: {
      title: 'International Data Transfers',
      content: 'Your information may be transferred to and processed in countries other than your country of residence. We ensure appropriate safeguards are in place to protect your information in accordance with this Privacy Policy.'
    },
    changes: {
      title: 'Changes to This Privacy Policy',
      content: 'We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date. Your continued use of our services after any modifications constitutes acceptance of the updated Privacy Policy.'
    },
    contact: {
      title: 'Contact Us',
      content: 'If you have any questions about this Privacy Policy or our data practices, please contact us:',
      email: 'Email',
      address: 'Address',
      addressValue: 'Dhaka, Bangladesh',
      phone: 'Phone'
    }
  },
  termsOfUse: {
    title: 'Terms of Use',
    lastUpdated: 'Last updated: January 2025',
    backButton: 'Go Back',
    introduction: {
      title: 'Introduction',
      content: 'Welcome to IncidentReport Bangladesh, a community-driven platform for reporting and tracking incidents across Bangladesh. These Terms of Use ("Terms") govern your use of our website, mobile application, and related services (collectively, the "Service").',
      agreement: 'By accessing or using our Service, you agree to be bound by these Terms. If you disagree with any part of these Terms, you may not access the Service.'
    },
    acceptance: {
      title: 'Acceptance of Terms',
      content: 'By using our Service, you acknowledge that you have read, understood, and agree to be bound by these Terms and our Privacy Policy.',
      conditions: 'You agree to comply with all applicable laws and regulations',
      legalAge: 'You are at least 18 years old or have parental consent',
      authority: 'You have the legal authority to enter into this agreement',
      compliance: 'You will comply with all terms and conditions set forth herein'
    },
    serviceDescription: {
      title: 'Description of Service',
      content: 'IncidentReport Bangladesh provides a platform for community members to report, track, and verify incidents across Bangladesh. Our Service includes:',
      reporting: 'Incident reporting and documentation tools',
      tracking: 'Real-time incident tracking and status updates',
      verification: 'Community-based incident verification system',
      community: 'Community discussion and collaboration features',
      analytics: 'Statistical analysis and reporting capabilities'
    },
    userAccounts: {
      title: 'User Accounts',
      registration: {
        title: 'Account Registration',
        accuracy: 'Provide accurate and complete information during registration',
        security: 'Maintain the security of your account credentials',
        responsibility: 'Take responsibility for all activities under your account',
        notification: 'Notify us immediately of any unauthorized use'
      },
      accountSecurity: {
        title: 'Account Security',
        password: 'Use a strong, unique password for your account',
        unauthorized: 'Report any unauthorized access attempts immediately',
        reporting: 'You are responsible for all activities under your account'
      }
    },
    acceptableUse: {
      title: 'Acceptable Use Policy',
      content: 'You agree to use our Service only for lawful purposes and in accordance with these Terms.',
      permitted: {
        title: 'Permitted Uses',
        reporting: 'Report genuine incidents and safety concerns',
        verification: 'Verify incidents based on personal knowledge',
        communication: 'Engage in respectful community discussions',
        legal: 'Use the Service in compliance with applicable laws'
      },
      prohibited: {
        title: 'Prohibited Uses',
        false: 'Submit false, misleading, or fraudulent incident reports',
        harassment: 'Harass, threaten, or intimidate other users',
        illegal: 'Use the Service for any illegal or unauthorized purpose',
        spam: 'Send spam, junk mail, or unsolicited communications',
        impersonation: 'Impersonate any person or entity',
        technical: 'Attempt to gain unauthorized access to our systems'
      }
    },
    contentGuidelines: {
      title: 'Content Guidelines',
      content: 'All content submitted to our platform must comply with these guidelines:',
      accuracy: 'Be accurate and truthful in all submissions',
      relevance: 'Stay relevant to incident reporting and community safety',
      respectful: 'Maintain respectful and professional communication',
      legal: 'Comply with all applicable laws and regulations',
      media: 'Only upload media that is relevant and appropriate'
    },
    privacy: {
      title: 'Privacy and Data Protection',
      content: 'Your privacy is important to us. Our collection and use of personal information is governed by our Privacy Policy.',
      collection: 'We collect only necessary information for service provision',
      usage: 'We use your information to provide and improve our services',
      sharing: 'We do not sell or rent your personal information',
      security: 'We implement appropriate security measures to protect your data'
    },
    intellectualProperty: {
      title: 'Intellectual Property Rights',
      ourContent: {
        title: 'Our Content',
        content: 'The Service and its original content, features, and functionality are owned by IncidentReport Bangladesh and are protected by international copyright, trademark, patent, trade secret, and other intellectual property laws.'
      },
      userContent: {
        title: 'User-Generated Content',
        content: 'You retain ownership of content you submit to our platform, but grant us certain rights to use it.',
        license: 'You grant us a non-exclusive, royalty-free license to use your content',
        warranty: 'You warrant that you have the right to submit the content',
        removal: 'We reserve the right to remove content that violates these Terms'
      }
    },
    disclaimers: {
      title: 'Disclaimers',
      content: 'The Service is provided on an "as is" and "as available" basis. We make no warranties, express or implied, regarding the Service.',
      accuracy: 'We do not guarantee the accuracy of user-submitted content',
      availability: 'We do not guarantee uninterrupted service availability',
      liability: 'We disclaim all liability for any damages arising from use of the Service',
      thirdParty: 'We are not responsible for third-party content or services'
    },
    limitationLiability: {
      title: 'Limitation of Liability',
      content: 'To the maximum extent permitted by law, IncidentReport Bangladesh shall not be liable for any indirect, incidental, special, consequential, or punitive damages.',
      damages: 'We are not liable for any damages resulting from use of the Service',
      incidents: 'We are not responsible for the accuracy of incident reports',
      thirdParty: 'We are not liable for third-party actions or content',
      maximum: 'Our total liability is limited to the amount you paid for the Service'
    },
    termination: {
      title: 'Termination',
      content: 'We may terminate or suspend your account and access to the Service immediately, without prior notice, for any reason whatsoever.',
      userTermination: 'You may terminate your account at any time',
      platformTermination: 'We may terminate accounts that violate these Terms',
      effect: 'Termination will not affect any rights or obligations that have already accrued',
      survival: 'Certain provisions will survive termination of these Terms'
    },
    governingLaw: {
      title: 'Governing Law and Dispute Resolution',
      content: 'These Terms shall be governed by and construed in accordance with the laws of Bangladesh.',
      jurisdiction: 'Any disputes will be subject to the exclusive jurisdiction of Bangladesh courts',
      disputes: 'We encourage resolution of disputes through good faith negotiation',
      arbitration: 'Disputes may be resolved through binding arbitration if necessary'
    },
    changes: {
      title: 'Changes to Terms',
      content: 'We reserve the right to modify these Terms at any time. We will notify users of any material changes.',
      notification: 'We will provide notice of changes through the Service or email',
      acceptance: 'Continued use of the Service constitutes acceptance of modified Terms',
      continued: 'If you disagree with changes, you must stop using the Service'
    },
    contact: {
      title: 'Contact Information',
      content: 'If you have any questions about these Terms, please contact us:',
      email: 'Email',
      address: 'Address',
      addressValue: 'Dhaka, Bangladesh',
      phone: 'Phone'
    },
    severability: {
      title: 'Severability',
      content: 'If any provision of these Terms is held to be invalid or unenforceable, the remaining provisions will remain in full force and effect.'
    },
    entireAgreement: {
      title: 'Entire Agreement',
      content: 'These Terms, together with our Privacy Policy, constitute the entire agreement between you and IncidentReport Bangladesh regarding the use of the Service.'
    }
  }
}

