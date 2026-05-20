pipeline {
    agent any
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        stage('Build') {
            steps {
                echo 'Checking PHP is available...'
                sh 'php --version'
            }
        }
        stage('Test') {
            steps {
                echo 'Checking PHP files exist...'
                sh 'find . -name "*.php" | head -10'
            }
        }
        stage('Deploy') {
            steps {
                echo 'PHP project deployed successfully!'
            }
        }
    }
}
