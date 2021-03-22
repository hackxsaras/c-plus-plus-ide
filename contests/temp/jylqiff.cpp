#include <bits/stdc++.h>
using namespace std;
int main(){
   int n;
   cin>>n;
   char c[n];
   char l;
   for(int i = 0; i<n;i++){
      cin>>c[i];
      if(c[i]=='B'){
         if(l=='U'){
            c[i]='D';
         } else {
            c[i]='U';
         }
      }
      l=c[i];
   }
   for(char b: c)cout<<b<<" ";
   cout << '\n';
   return 0;
}