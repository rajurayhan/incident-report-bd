export default {
  nav: {
    logo: 'Incident Report Bangladesh',
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
    fileTooLarge: 'File {fileName} is too large. Maximum size is 10MB.',
    maxFilesReached: 'Maximum 3 files allowed. Please remove some files before adding new ones.',
    maxFilesExceeded: 'You can only upload a maximum of 3 files.'
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
    addComment: 'Add a comment... (Use @ to mention users)',
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
}

