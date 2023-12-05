#!groovy

timestamps {
  node {
    cleanWs()
    checkout scm

    // Code quality tests+ allure code begins
    try {
      sh '/usr/local/bin/composer install -o'

      stage('PHP CodeSniffer (Linting)') {
        sh '/usr/local/bin/composer run-phpcs'
      }
      stage('PHP Lint (Syntax)') {
        sh '/usr/local/bin/composer run-phplint'
      }
      stage('PHP Mess Detector (Code Format/Complexity)') {
        sh '/usr/local/bin/composer run-phpmd'
      }
      stage('PHP Unit (Functional)') {
        sh '/usr/local/bin/composer run-phpunit'
      }
      // @TODO: Uncomment this block if you have JS Unit Tests
      // stage('JS Unit Tests') {
      //   sh 'yarn'
      //   sh 'yarn test'
      // }
    } catch (e) {
       currentBuild.result = 'FAILURE'
    } finally {
       // Delete old build Allure report directory if it exists
       if (fileExists('allure-report')) {
          sh 'rm -rf allure-report*'
       }

       // Generate Allure reports and show in the build process
       allure commandline: 'allure_2',
          jdk: '',
          results: [
                [
                  path: 'build/allure-results'
                ]
          ]
    }
    // Code quality tests + allure code ends
  }

  // Build jobs from branches with '/' have the '/' URL-encoded
  def sanitisedBranchName = (env.BRANCH_NAME).replace("/", "%2F")
  switch (env.BRANCH_NAME) {

    // @TODO: Uncomment this code when you are ready to start triggering develop builds
    // (i.e. after this submodule has been added into wcp-core)
    // case "develop":
    //   build "../wcp-core/${sanitisedBranchName}"
    //   break

    default:
      echo "Triggering origin build for ${env.BRANCH_NAME}"
  }
}
